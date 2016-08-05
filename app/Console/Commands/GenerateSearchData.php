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
                'link' => env('APP_URL') . '/bai-hat/' . $song->song_title_slug.'.html'
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
                'link' => env('APP_URL') . '/playlist/' . $playlist->playlist_title_slug.'.html'
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
                'link' => env('APP_URL') . '/nghe-si/' . $artist->artist_title_slug .'.html'
            ];
        }


        $this->info("--Writing to file....");

//        $all = array_merge($song1, $song2, $playlist1, $playlist2);
        $all = array_merge($song_records, $playlist_records, $artist_records);
//        asort($all);
//        $final = [];
//        foreach ($all as $k => $v) {
//            $final[] = (object)[
//                'title' => htmlspecialchars($k),
//                'slug' => htmlspecialchars($v)
//            ];
//        }


        $content = json_encode($all);
        $path = base_path() . '/public/json/search_data.json';
        file_put_contents($path, $content);

        $this->info("--Complete writing!");
    }
}
