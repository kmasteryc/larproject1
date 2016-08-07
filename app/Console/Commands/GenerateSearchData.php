<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Song;
use App\Playlist;
use App\Artist;

class GenerateSearchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("--Dumping songs");

        $songs = Song::select('id', 'song_title', 'song_title_eng', 'song_title_slug')
            ->orderBy('song_title_eng','ASC')
            ->get();
        $song_records = [];
        foreach ($songs as $song) {
            $song_records[] = [
                'title' => $song->song_title,
                'title_eng' => $song->song_title_eng,
                'link' => env('APP_URL') . '/bai-hat/' . $song->song_title_slug.'.html',
                'link_edit' => env('APP_URL') . '/song/' . $song->id.'/edit',
            ];
        }


        $this->info("--Dumping playlists");

        $playlists = Playlist::select('id', 'playlist_title', 'playlist_title_eng', 'playlist_title_slug')
            ->orderBy('playlist_title_eng','ASC')
            ->get();
        $playlist_records = [];
        foreach ($playlists as $playlist) {
            $playlist_records[] = [
                'title' => $playlist->playlist_title,
                'title_eng' => $playlist->playlist_title_eng,
                'link' => env('APP_URL') . '/playlist/' . $playlist->playlist_title_slug.'.html',
                'link_edit' => env('APP_URL') . '/playlist/' . $playlist->id.'/edit'
            ];
        }


        $this->info("--Dumping artists");

        $artists = Artist::select('id', 'artist_title', 'artist_title_eng', 'artist_title_slug')
            ->orderBy('artist_title_eng', 'ASC')
            ->get();
        $artist_records = [];
        foreach ($artists as $artist) {
            $artist_records[] = [
                'title' => $artist->artist_title,
                'title_eng' => $artist->artist_title_eng,
                'link' => env('APP_URL') . '/nghe-si/' . $artist->artist_title_slug .'.html',
                'link_edit' => env('APP_URL') . '/artist/' . $artist->id.'/edit'
            ];
        }


        $this->info("--Writing to file....");

        $all = array_merge($song_records, $playlist_records, $artist_records);

        $content_all = json_encode($all);
        $content_song = json_encode($song_records);
        $content_artist = json_encode($artist_records);
        $content_playlist = json_encode($playlist_records);

        $path_all = base_path() . '/public/json/search_data.json';
        $path_song = base_path() . '/public/json/search_song_data.json';
        $path_artist = base_path() . '/public/json/search_artist_data.json';
        $path_playlist = base_path() . '/public/json/search_playlist_data.json';

        file_put_contents($path_all, $content_all);
        file_put_contents($path_song, $content_song);
        file_put_contents($path_artist, $content_artist);
        file_put_contents($path_playlist, $content_playlist);

        $this->info("--Complete writing!");
    }
}
