<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp;

class DownloadMP3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download remote MP3 to local Storage';

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
        $songs = \App\Song::all();
        $this->info("Welcome to console! Start downloading " . count($songs) . " songs..");
        $i = 1;
        foreach ($songs as $song) {
            $this->info("----Downloading song $i/" . count($songs) . PHP_EOL);
            $this->info("from: " . $song->song_mp3 . PHP_EOL);
            $song_img_name = rand(1, 99999) . $song->song_title_slug . '.mp3';

            $client = new GuzzleHttp\Client();
            try {
                $res = $client->request('GET', $song->song_mp3);

                if ($res->getStatusCode() == 200) {
                    $source = $res->getBody();
                    file_put_contents(base_path('public/uploads/mp3/') . $song_img_name, $source);
                    $this->info("to: " . $song_img_name);
                    $song->song_mp3 = asset('uploads/mp3/' . $song_img_name);
                    $song->save();

                }
            } catch (\Exception $e) {
                $this->error("----FAILED: Downloading song $i/" . count($songs) . PHP_EOL);
            }
            $i++;
        }
        $this->info("DOWNLOAD SUCCESS! Ctrl+C to exit...");
    }
}
