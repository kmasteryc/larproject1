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
use Tools\Import;

class ImportController extends Controller
{
    public function create()
	{
		return view('imports.create');
	}
	public function store(Request $request)
	{
		$data = new Import($request->url);
		if ($data->getResults() == '')
		{
			return back()->withErrors($data->getErrors());
		}
		else
		{
			$songs = $data->getResults();
			// Create playlists
			$playlist = new Playlist;
			$playlist->playlist_title = $request->playlist_title;
			$playlist->cate_id = $request->cate_id;
			$playlist->user_id = auth()->user()->id;
			$playlist->save();

			// Create images
			$image = new Image;
			$image->image_path = $songs[0]['playlist_img'];
			$image->imageable_id = $playlist->id;
			$image->imageable_type = Playlist::class;
			$image->save();

			// Create individual song

			foreach ($songs as $song)
			{
				$newsong = new Song;
				$newsong->song_title = $song['title'];
				$newsong->cate_id = $request->cate_id;
				$newsong->song_mp3 = $song['source'];
				$newsong->save();

				//Create lyric if exist
				if ($song['lyric']!='')
				{
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
}
