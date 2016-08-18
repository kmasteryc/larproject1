<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Cate;
use App\Image;
use App\Lyric;
use App\Playlist;
use App\Song;
use Illuminate\Http\Request;
use GuzzleHttp;
use App\Http\Requests;
use Mockery\CountValidator\Exception;
use Tools\Import;
use Faker;

class ImportController extends Controller
{

	public $single_artist;
	public $artists = [];
	static $cur_song = 0;
	static $max_song = 50; //~5GB mp3 song

	public function __construct()
	{
		set_time_limit(0);
	}

	public function importPlaylist()
	{
		return view('imports.import_playlist');
	}

	/**
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function storePlaylist(Request $request)
	{
		$data = new Import($request->url);
//		dd($data->getResults());
		if ($data->getResults() == '') {
			return back()->withErrors($data->getErrors());
		}

		$faker = Faker\Factory::create();
		$songs = $data->getResults();

		$playlist = new Playlist;
		$playlist->playlist_title = $request->playlist_title;
		$playlist->playlist_title_eng = str_replace('-', ' ', str_slug($request->playlist_title));

		$playlist->playlist_info = $faker->sentence(200);
		$playlist->cate_id = $request->cate_id;
		$playlist->user_id = auth()->user()->id;

		$name = rand(1, 999999) . basename($songs[0]['playlist_img']);
		$path = base_path('public/uploads/imgs/playlists/' . $name);
		file_put_contents($path, file_get_contents($songs[0]['playlist_img']));
		$playlist->playlist_img = asset('uploads/imgs/playlists/' . $name);

		foreach ($songs as $song) {

			$newsong = Song::where('song_title', $song['title'])->first();
			if ($newsong == null) {
				$newsong = new Song;
				$newsong->song_title = $song['title'];
				$newsong->song_title_eng = str_replace('-', ' ', str_slug($song['title']));
				$newsong->cate_id = $request->cate_id;
				$newsong->song_mp3 = $song['source'];
				$newsong->save();

				if ($song['lyric'] != '' && preg_match('/.lrc$/', $song['lyric'])) {
					$lyric = new Lyric;
					$lyric->lyric_content = file_get_contents($song['lyric']);
					$lyric->user_id = auth()->user()->id;
					$lyric->song_id = $newsong->id;
					$lyric->save();
				}
				$artists_title = explode(' , ', trim($song['performer']));

				foreach ($artists_title as $artist_title) {
					$artist = Artist::where('artist_title', $artist_title)
						->where('artist_title', '<>', 'Nhiều Ca Sĩ')
						->first();
					if ($artist == null) {
						$artist = Artist::createNewArtist($artist_title);
					}
					if ($artist != '') {

						if (!array_key_exists($artist->artist_title_slug, $this->artists)) {
							$this->artists[$artist->artist_title_slug] = $artist;
						}

						$artist_title_slug = $artist->artist_title_slug;
						$rand_str = substr(md5(rand(1, 1111)), 0, 5);
						$newsong->song_title_slug = str_slug($song['title']) . '-' . $artist_title_slug . '-' . $rand_str;

						$newsong->save();
						$newsong->artists()->attach($artist);

					}
				}

			}
			$song_ids[] = $newsong->id;

			self::$cur_song++;
		}

		if (count($this->artists) == 1) {
			$artist = array_shift($this->artists);
		} else {
			$artist = Artist::find(1);
		};

		$artist_title_slug = $artist->artist_title_slug;
		$rand_str = substr(md5(rand(1, 1111)), 0, 5);
		$playlist->artist_id = $artist->id;
		$playlist->playlist_title_slug = str_slug($request->playlist_title) . '-' . $artist_title_slug . '-' . $rand_str;

		$playlist->save();
		$playlist->songs()->sync($song_ids);

		if (self::$cur_song > self::$max_song) {
			echo "Maximum " . self::$max_song . ' reach!';
//			self::$cur_song = 0;
			return false;
		}
		return true;
	}

	public function importCate()
	{
		return view('imports.import_cate', ['cates' => Cate::all()]);
	}

	public function storeCate(Request $request)
	{
//        dd($request->all());
		$client = new GuzzleHttp\Client();

		$res = $client->request('GET', $request->url);

		if ($res->getStatusCode() == 200) {
			// Get all album url from specificed category
			$html = $res->getBody();

			$titles = $this->getPlaylistTitle($html);
			$urls = $this->getLinkPlaylist($html);

			foreach ($urls as $k => $url) {
				$title = strstr($titles[$k], ' - ', true);
				$title = str_replace('Album ', '', $title);

				$new_request = new Request;
				$new_request->cate_id = $request->cate_id;
				$new_request->url = $url;
				$new_request->playlist_title = $title;

				$continue = $this->storePlaylist($new_request);
				if ($continue == false) break;
			}

		}

	}

	public function syncArtistImage()
	{
		$artists = Artist::where('id', '<>', 1)->get();

		foreach ($artists as $artist) {
//            if ($artist->artist_img_small != '' || $artist->artist_img_cover != '') {
			$url = "http://mp3.zing.vn/nghe-si/" . str_slug($artist->artist_title);

			$client = new \GuzzleHttp\Client();
			try {
				$res = $client->request('GET', $url);

				if ($res->getStatusCode() == 200) {

					preg_match_all('/container">         <img src="([^"]+)"/', $res->getBody(), $match1);
					preg_match_all('/<div class="inside">.*src="([^"]+)"/', $res->getBody(), $match2);

					$cover_img = $match1[1][0];
					$small_img = $match2[1][0];

					$cover_path = base_path('public/uploads/imgs/artists/' . basename($cover_img));
					$small_path = base_path('public/uploads/imgs/artists/' . basename($small_img));

					file_put_contents($cover_path, file_get_contents($cover_img));
					file_put_contents($small_path, file_get_contents($small_img));

					$artist->artist_img_small = asset('uploads/imgs/artists/' . basename($small_img));
					$artist->artist_img_cover = asset('uploads/imgs/artists/' . basename($cover_img));

					$artist->save();

					sleep(100);
				}
			} catch (Exception $e) {
				echo $e;
			}
//            }

		}

	}

	public function getPlaylistTitle($content)
	{
		preg_match_all('/"thumb" title="([^"]+)/', $content, $match_titles);
		return $match_titles[1];
	}

	public function getLinkPlaylist($content)
	{
		preg_match_all('/href="(http:\/\/mp3.zing.vn\/album\/[a-zA-Z0-9\-\/]+.html)" class="thumb"/', $content, $match_urls);
		return $match_urls[1];
	}
}
