<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 26/07/2016
 * Time: 21:10
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Song;
use App\Playlist;
use App\View;
use Illuminate\Support\Facades\DB;

class Chart extends Model
{

    const TIME_WEEK = 1;
    const TIME_MONTH = 2;

    public static function get_song_records($time_mode, $cate, $index, $num)
    {

        switch ($time_mode) {
            case self::TIME_WEEK:

                $day_number_in_year = $index * 7;
                $dt = Carbon::createFromFormat('z', $day_number_in_year);
                $first_day_of_week = $dt->startOfWeek();

                // Get all days in week
                $all_days = [];
                for ($i = 0; $i <= 6; $i++) {
                    $all_days[] = $first_day_of_week->addDay($i)->toDateString();
                    // roll back for next loop
                    $first_day_of_week->subDay($i);
                }

                break;

            case self::TIME_MONTH:

                $dt = Carbon::createFromFormat('m', $index);
                $first_day_of_month = $dt->startOfMonth();

                // Get all days in month
                $all_days = [];
                for ($i = 0; $i < $dt->daysInMonth; $i++) {
                    $all_days[] = $first_day_of_month->addDay($i)->toDateString();
                    // roll back for next loop
                    $first_day_of_month->subDay($i);
                }

                break;
        }


        $views = View::whereIn('view_date', $all_days)
            ->where('viewable_type', Song::class)
            ->with(['viewable' => function ($query) {
                $query->with(['artists', 'cate']);
            }])->get();

        return self::_processSongViews($views, $cate, $num);
    }

    public static function get_playlist_records($time_mode, $cate, $index, $num)
    {
        switch ($time_mode) {
            case self::TIME_WEEK:

                $day_number_in_year = $index * 7;
                $dt = Carbon::createFromFormat('z', $day_number_in_year);
                $first_day_of_week = $dt->startOfWeek();

                // Get all days in week
                $all_days = [];
                for ($i = 0; $i <= 6; $i++) {
                    $all_days[] = $first_day_of_week->addDay($i)->toDateString();
                    // roll back for next loop
                    $first_day_of_week->subDay($i);
                }

                break;

            case self::TIME_MONTH:

                $dt = Carbon::createFromFormat('m', $index);
                $first_day_of_month = $dt->startOfMonth();

                // Get all days in month
                $all_days = [];
                for ($i = 0; $i < $dt->daysInMonth; $i++) {
                    $all_days[] = $first_day_of_month->addDay($i)->toDateString();
                    // roll back for next loop
                    $first_day_of_month->subDay($i);
                }

                break;
        }

        $views = View::whereIn('view_date', $all_days)
            ->where('viewable_type', Playlist::class)
            ->with(['viewable' => function ($query) {
                $query->with('artist', 'cate');
            }])->get();

        return self::_processPlaylistViews($views, $cate, $num);
    }

    private static function _processSongViews($views, $cate, $num)
    {
        $song_data = [];
        $child_cates = Cate::getMeAndMyChilds($cate);

        foreach ($views as $view) {
            $song = $view->viewable;

            if (in_array($song->cate->cate_title_slug, $child_cates)) {

                if (!array_key_exists($song->id, $song_data)) {
                    $song_data[$song->id]['song_view_count'] = $view->view_count;
                    $song_data[$song->id]['song_title'] = $song->song_title;
                    $song_data[$song->id]['song_title_slug'] = $song->song_title_slug;
                    $song_data[$song->id]['song_id'] = $song->id;
                    $song_data[$song->id]['song_artist'] = $song->artists->first()->artist_title;
                    $song_data[$song->id]['song_artist_id'] = $song->artists->first()->id;
                    $song_data[$song->id]['song_artist_img'] = $song->artists->first()->artist_img_small;
                    $song_data[$song->id]['song_artist_title_slug'] = $song->artists->first()->artist_title_slug;
                    $song_data[$song->id]['song_mp3'] = $song->song_mp3;
                } else {
                    $song_data[$song->id]['song_view_count'] += $view->view_count;
                }
            }
        }

        // Bubble sort
        $elements = count($song_data);

        // Bubble sort cannot use with non-numeric index array => Prepare for bubble sort. Option: convert to object for convinent with laravel
        $new_song_data = [];
        foreach ($song_data as $data) {
            $new_song_data[] = (object)$data;
        }

        while (true) {
            $swap = false;
            for ($i = 0; $i < $elements - 1; $i++) {

                $a = $new_song_data[$i];
                $b = $new_song_data[$i + 1];

                if ($a->song_view_count > $b->song_view_count) {
                    $swap = true;
                    $c = $new_song_data[$i + 1];
                    $new_song_data[$i + 1] = $new_song_data[$i];
                    $new_song_data[$i] = $c;
                }

            }
            if ($swap === false) {
                break;
            }
        }

        $new_song_data = array_reverse($new_song_data);
        return array_slice($new_song_data, 0, $num);
    }

    private static function _processPlaylistViews($views, $cate, $num)
    {
        $playlist_data = [];
        $child_cates = Cate::getMeAndMyChilds($cate);

        foreach ($views as $view) {

            $playlist = $view->viewable;

            if (in_array($playlist->cate->cate_title_slug, $child_cates)) {

                if (!array_key_exists($playlist->id, $playlist_data)) {
                    $playlist_data[$playlist->id]['playlist_view_count'] = $view->view_count;
                    $playlist_data[$playlist->id]['playlist_title'] = $playlist->playlist_title;
                    $playlist_data[$playlist->id]['playlist_title_slug'] = $playlist->playlist_title_slug;
                    $playlist_data[$playlist->id]['playlist_id'] = $playlist->id;
                    $playlist_data[$playlist->id]['playlist_artist'] = $playlist->artist->artist_title;
                    $playlist_data[$playlist->id]['playlist_artist_id'] = $playlist->artist->id;
                    $playlist_data[$playlist->id]['playlist_artist_title_slug'] = $playlist->artist->artist_title_slug;
                    $playlist_data[$playlist->id]['playlist_img'] = $playlist->playlist_img;
                } else {
                    $playlist_data[$playlist->id]['playlist_view_count'] += $view->view_count;
                }
            }
        }

        // Bubble sort
        $elements = count($playlist_data);

        // Bubble sort cannot use with non-numeric index array => Prepare for bubble sort. Option: convert to object for convinent with laravel
        $new_playlist_data = [];
        foreach ($playlist_data as $data) {
            $new_playlist_data[] = (object)$data;
        }

        while (true) {
            $swap = false;
            for ($i = 0; $i < $elements - 1; $i++) {

                $a = $new_playlist_data[$i];
                $b = $new_playlist_data[$i + 1];

                if ($a->playlist_view_count > $b->playlist_view_count) {
                    $swap = true;
                    $c = $new_playlist_data[$i + 1];
                    $new_playlist_data[$i + 1] = $new_playlist_data[$i];
                    $new_playlist_data[$i] = $c;
                }

            }
            if ($swap === false) {
                break;
            }
        }

        $new_playlist_data = array_reverse($new_playlist_data);
        return array_slice($new_playlist_data, 0, $num);
    }
}