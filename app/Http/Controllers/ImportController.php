<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Image;
use App\Lyric;
use App\Playlist;
use App\Song;
use Illuminate\Http\Request;
use Guzzle\Http as GuzzleHttp;
use App\Http\Requests;
use Mockery\CountValidator\Exception;
use Tools\Import;
use Faker;

class ImportController extends Controller
{
    public function importPlaylist()
    {
        return view('imports.import_playlist');
    }

    public function storePlaylist(Request $request)
    {
        $data = new Import($request->url);
        if ($data->getResults() == '') {
            return back()->withErrors($data->getErrors());
        } else {
            $faker = Faker\Factory::create();
//			dd($data->getResults());
            $songs = $data->getResults();
            // Create playlists
            $playlist = new Playlist;
            $playlist->playlist_title = $request->playlist_title;
            $playlist->playlist_img = $songs[0]['playlist_img'];
            $playlist->playlist_info = $faker->sentence(200);
            $playlist->cate_id = $request->cate_id;
            $playlist->user_id = auth()->user()->id;
            $playlist->artist_id = 1;
            $playlist->save();

//            // Create images
//            $image = new Image;
//            $image->image_path = $songs[0]['playlist_img'];
//            $image->imageable_id = $playlist->id;
//            $image->imageable_type = Playlist::class;
//            $image->save();

            // Create individual song

            foreach ($songs as $song) {
                $newsong = new Song;
                $newsong->song_title = $song['title'];
                $newsong->cate_id = $request->cate_id;
                $newsong->song_mp3 = $song['source'];
                $newsong->song_img = $song['backimage'];
                $newsong->save();

                //Create lyric if exist
                if ($song['lyric'] != '') {
                    $lyric = new Lyric;
                    $lyric->lyric_content = file_get_contents($song['lyric']);
                    $lyric->user_id = auth()->user()->id;
                    $lyric->song_id = $newsong->id;
                    $lyric->save();
                }

                // Process artists
                // Create new artist if not exist, attach songs to artist
                $performers = explode('  ft. ', trim($song['performer']));
                Artist::createAndAttach($performers, $newsong);

                // Attach songs to playlist
                $playlist->songs()->attach($newsong);
            }
        }

    }

    public function syncArtistImage()
    {
        $artists = Artist::where('id', '<>', 1)->get();
//
//        foreach ($artists as $artist)
//        {
//            $artist->artist_img_small = str_replace('public/','',$artist->artist_img_small);
//            $artist->artist_img_cover = str_replace('public/','',$artist->artist_img_cover);
//            $artist->save();
//        }exit;

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
}
