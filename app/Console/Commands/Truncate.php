<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Truncate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate';

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('songs')->truncate();
        DB::table('playlists')->truncate();
        DB::table('artists')->truncate();
        DB::table('views')->truncate();
        DB::table('artist_song')->truncate();
        DB::table('playlist_song')->truncate();


        DB::table('artists')->insert(
            [
                'artist_title' => 'Nhiều nghệ sĩ',
                'artist_title_slug' => 'nhieu-nghe-si',
                'artist_name' => 'Various Artists',
                'artist_title_eng' => 'nhieu nghe si',
                'artist_info' => 'A group òf Artists to perform songs or albums',
                'artist_birthday' => '2016-08-01',
                'artist_img_small' => '',
                'artist_img_cover' => '',
                'artist_gender' => 1,
                'nation_id' => 84
            ]
        );
		exec("rm -r ".base_path('public/uploads/imgs/playlists'));
		exec("rm -r ".base_path('public/uploads/imgs/artists'));

	    exec("mkdir ".base_path('public/uploads/imgs/artists'));
	    exec("mkdir ".base_path('public/uploads/imgs/playlists'));

        $this->info("Truncate complete! Ctrl+C to quit...");
    }
}
