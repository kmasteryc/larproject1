<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Song;
use App\View;
use App\Playlist;
use Faker;
use Illuminate\Support\Facades\DB;


class SeedView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seedview';

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
        $this->info("Start truncate view table".PHP_EOL);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('views')->truncate();

        $this->info("Truncate complete!".PHP_EOL);

        $playlists = Playlist::all();

        $count_playlist = 0;

        $this->info("Begin seed playlist view!".PHP_EOL);

        for ($i=1; $i<=20; $i++)
        {
            foreach ($playlists as $playlist)
            {
                if (rand(1,5) != 2)
                {
                    $count_playlist ++;
                    $faker = Faker\Factory::create();

                    $new_view = new View;

                    $new_view->viewable_type = 'App\Playlist';
                    $new_view->viewable_id = $playlist->id;
                    $new_view->view_count = rand(1,222);
                    $new_view->user_id = 1;
                    $new_view->view_date = $faker->dateTimeThisYear(\Carbon\Carbon::now()->endOfYear()->toDateTimeString());

                    $new_view->save();
                }
            }
        }
        $this->info("Seed playlist complete!".PHP_EOL);

        $songs = Song::all();
        $count_song = 0;

        $this->info("Begin seed song view!".PHP_EOL);

        for ($i=1;$i<=3;$i++)
        {
            foreach ($songs as $song)
            {
                if (rand(1,4) != 2)
                {
                    $count_song++;
                    $faker = Faker\Factory::create();

                    $new_view = new View;

                    $new_view->viewable_type = 'App\Song';
                    $new_view->viewable_id = $song->id;
                    $new_view->view_count = rand(1,241);
                    $new_view->user_id = 1;
                    $new_view->view_date = $faker->dateTimeThisYear(\Carbon\Carbon::now()->endOfYear()->toDateTimeString());

                    $new_view->save();
                }
            }
        }

        $this->info("Seed song complete!".PHP_EOL);

        $this->info("Reseed View table complete! Add $count_playlist playlists, $count_song songs");
    }
}
