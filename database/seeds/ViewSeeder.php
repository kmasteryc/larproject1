<?php

use Illuminate\Database\Seeder;

use App\Song;
use App\View;
use App\Playlist;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playlists = Playlist::all();

        for ($i=1;$i<=222;$i++)
        {
            foreach ($playlists as $playlist)
            {
                if (rand(1,5) != 2)
                {
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
//        $songs = Song::all();
//
//        for ($i=1;$i<=100;$i++)
//        {
//            foreach ($songs as $song)
//            {
//                if (rand(1,4) != 2)
//                {
//                    $faker = Faker\Factory::create();
//
//                    $new_view = new View;
//
//                    $new_view->viewable_type = 'App\Song';
//                    $new_view->viewable_id = $song->id;
//                    $new_view->view_count = rand(1,555);
//                    $new_view->user_id = 1;
//                    $new_view->view_date = $faker->dateTimeThisYear(\Carbon\Carbon::now()->endOfYear()->toDateTimeString());
//
//                    $new_view->save();
//                }
//            }
//        }
    }
}
