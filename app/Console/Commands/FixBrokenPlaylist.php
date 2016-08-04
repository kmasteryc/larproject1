<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Playlist;

class FixBrokenPlaylist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixbrokenplaylist';

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
        $playlists = Playlist::with('songs')->get();
        $count = 0;
        $empty_pl = [];
        foreach ($playlists as $playlist)
        {
            if (count($playlist->songs) == 0)
            {
                $count++;
                $empty_pl[] = $playlist->id;
                $playlist->delete();
            }
        }

        if ($count>0){
            $this->info("-- Deleted $count empty playlist. Reseed view tables");
            $this->call('seedview');
        }
        $this->info("-- Fix $count playlists with empty song! ".implode(',',$empty_pl));

    }
}
