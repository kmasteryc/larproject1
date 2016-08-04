<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Song;

class FixBrokenSong extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixbrokensong';

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
        $songs = Song::with('artists')->get();

        $i = 0;
        foreach ($songs as $song){
            if (count($song->artists) == 0 || $song->song_mp3 == ""){
                $i++;
                $song->playlists()->detach();
                $song->delete();
            }
        }
        $this->info("Deleted $i broken songs!");
    }
}
