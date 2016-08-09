<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests;
use App\Playlist;
use App\Artist;
use Carbon\Carbon;

use App\Http\Requests\Playlists\StoreRequest;
use App\Http\Requests\Playlists\UpdateRequest;

class PlaylistController extends Controller
{
    public function index()
    {
        if (Gate::check('is-admin')) {
            $playlists = Playlist::orderBy('updated_at', 'desc')
                ->with('songs', 'cate')
                ->get();
        } else {
            $playlists = Playlist::where('user_id', auth()->user()->id)
                ->orderBy('updated_at', 'desc')
                ->with('songs', 'cate')
                ->get();
        }

        return view('playlists.index', [
            'myjs' => ['jquery.dynatable.js','playlists/index.js'],
            'mycss' => ['jquery.dynatable.css'],
            'playlists' => $playlists,
            'cp' => true
        ]);
    }

    public function create()
    {
        return view('playlists.create', [
            'artists' => Artist::where('id', '<>', 1)->orderBy('artist_title', 'ASC')->get(),
            'myjs' => ['playlists/create.js'],
            'cp' => true
        ]);
    }

    public function store(StoreRequest $request)
    {
        // Move upload image to appriciate location
        $playlist_img = request()->file('playlist_img');
        $playlist_img_name = rand(1, 99999) . $playlist_img->getClientOriginalName();
        $playlist_img->move(base_path('public/uploads/imgs/playlists'), $playlist_img_name);

        // After uploading was done. Do insert info to DB
        $link = asset('uploads/imgs/playlists/' . $playlist_img_name);

        $artist_id = $request->artist_id === 0 ? 1 : $request->artist_id;

        $artist = Artist::find($artist_id);
        $artist_title_slug = $artist->artist_title_slug;
        $randstring = substr(md5(rand(1, 999)), 0, 5);


        $playlist = new Playlist;
        $playlist->playlist_title = $request->playlist_title;
        $playlist->playlist_title_slug = str_slug($playlist->playlist_title) . '-' . $artist_title_slug . '-' . $randstring;
        $playlist->playlist_title_eng = str_replace('-', ' ', $playlist->playlist_title_slug);
        $playlist->playlist_img = $link;
        $playlist->playlist_info = $request->playlist_info;
        $playlist->cate_id = $request->cate_id;
        $playlist->user_id = $request->user()->id;
        $playlist->artist_id = $artist_id;
        $playlist->save();

        $songs = explode(',', $request->playlist_songs);

        /*Here i have 2 opts:
        first: $song->artists()->attach($artist)
        second: $artist->songs()->attach($song->id);*/

        foreach ($songs as $song) {
            if ($song != '') $playlist->songs()->attach($song);
        }

        return back()->with('succeeds', 'Tao danh sach nhac thanh cong!');
    }

    public function edit(Playlist $playlist)
    {
        if (!Gate::check('is-admin') && auth()->user()->id != $playlist->user_id) {
            session()->flash('my_errors', 'Bạn không có quyền chỉnh sửa Danh sách nhạc của người khác!');
            return redirect()->route('home');
        }

        return view('playlists.edit', [
            'myjs' => ['playlists/create.js'],
            'artists' => Artist::orderBy('artist_title', 'ASC')->get(),
            'playlist' => $playlist,
            'cp' => true
        ]);
    }

    public function update(UpdateRequest $request, Playlist $playlist)
    {
        if (!Gate::check('is-admin') && auth()->user()->id != $playlist->user_id) {
            session()->flash('my_errors', 'Bạn không có quyền chỉnh sửa danh sách nhạc của người khác!');
            return redirect()->route('home');
        }

        $artist_id = $request->artist_id === 0 ? 1 : $request->artist_id;

        $artist = Artist::find($artist_id);
        $artist_title_slug = $artist->artist_title_slug;
        $randstring = substr(md5(rand(1, 999)), 0, 5);

        $playlist->playlist_info = $request->playlist_info;
        $playlist->playlist_title = $request->playlist_title;
        $playlist->playlist_title_slug = str_slug($playlist->playlist_title) . '-' . $artist_title_slug . '-' . $randstring;
        $playlist->playlist_title_eng = str_replace('-', ' ', $playlist->playlist_title_slug);
        $playlist->artist_id = $artist_id;
        $playlist->cate_id = $request->cate_id;


        $playlist_img = $request->file('playlist_img');
        if ($playlist_img) {
            // Remove old img
            preg_match("/imgs\/(.*)/", $playlist->playlist_img, $temp);
            @unlink(base_path('public/uploads/imgs/' . $temp[1]));

            // Move upload image to appriciate location
            $playlist_img_name = rand(1, 99999) . $playlist_img->getClientOriginalName();
            $playlist_img->move(base_path('public/uploads/imgs/playlists'), $playlist_img_name);

            // After uploading was done. Do insert info to DB
            $link = asset('uploads/imgs/playlists/' . $playlist_img_name);

            $playlist->playlist_img = $link;
        }

        $playlist->save();

        // Process playlist_songs
        // First we remove old song_artists
        $playlist->songs()->detach();
        $songs = explode(',', $request->playlist_songs);

        /*Here i have 2 opts:
        first: $song->artists()->attach($artist)
        second: $artist->songs()->attach($song->id);*/

        foreach ($songs as $song) {
            if ($song != '') $playlist->songs()->attach($song);
        }

        return back()->with('succeeds', 'Cap nhat danh sach nhac thanh cong!');
    }

    public function delete(Playlist $playlist, Request $request)
    {
        if (!Gate::check('is-admin') && auth()->user()->id != $playlist->user_id) {
            session()->flash('my_errors', 'Bạn không có quyền truy cập Danh sách nhạc của người khác!');
            return back();
        }

        $playlist->songs()->detach();
        $playlist->delete();

        $request->session()->flash('succeeds', 'Your done!');
        return back();
    }

    public function show($playlist)
    {
        // Is number and > 0 => user playlist
        if ($playlist instanceof Playlist) {

            SessionController::increase_view_playlist($playlist);

            $other_playlists = Playlist::where(
                [
                    ['cate_id', $playlist->cate->id],
                    ['id', '<>', $playlist->id]
                ])
                ->orWhere([
                    ['id', '<>', $playlist->id],
                    ['cate_id', $playlist->cate->cate_parent]
                ])
                ->inRandomOrder()->take(5)->with('artist','views')->get();

            return view('playlists.show', [
                'title' => $playlist->playlist_title,
                'myjs' => ['player.js', 'playlists/show.js'],
                'playlist' => $playlist,
                'other_playlists' => $other_playlists,
                'api_url_1' => url("api/get-songs-in-playlist/$playlist->id"),
                'api_url_2' => url("api/get-nontime-lyrics/"),
            ]);

        } else { // Else it is temporary playlist

            return view('playlists.guest_show', [
                'myjs' => ['player.js', 'playlists/guest_show.js'],
                'api_url_1' => url("api/get-songs-in-playlist/danh-sach-tam"),
                'api_url_2' => url("api/get-nontime-lyrics/")
            ]);
        }

    }

    public function show_chart($cate, $week_or_month = 'tuan', $index = '')
    {
//        dd(func_get_args());
        switch ($week_or_month):
            case 'tuan': // Default for week and otherwise
                $index = $index == '' ? Carbon::now()->subWeek(1)->weekOfYear : $index;
                $index = $index < 1 ? 1 : $index;
                $cur_real_index = Carbon::now()->weekOfYear;
                $start_date = Carbon::createFromFormat('z', $index * 7)->startOfWeek()->format('d/m');
                $end_date = Carbon::createFromFormat('z', $index * 7)->endOfWeek()->format('d/m');
                $max_interval = 52;
                $time_unit = 'TUẦN';
                break;

            case 'thang': // Month
                $index = $index == '' ? Carbon::now()->subMonth(1)->month : $index;
                $index = $index < 1 ? 1 : $index;
                $cur_real_index = Carbon::now()->month;
                $start_date = Carbon::createFromFormat('m', $index)->startOfMonth()->format('d/m');
                $end_date = Carbon::createFromFormat('m', $index)->endOfMonth()->format('d/m');
                $max_interval = 12;
                $time_unit = 'THÁNG';
                break;
        endswitch;

        return view('playlists.chart_show', [
            'title' => 'BẢNG XẾP HẠNG',
            'myjs' => ['player.js', 'playlists/show.js'],
            'api_url_1' => url("api/get-songs-in-chart/$cate->cate_title_slug/$week_or_month/$index"),
            'api_url_2' => url("api/get-nontime-lyrics/"),
            'timeinfo' => [
                'time_unit' => $time_unit,
                'max_interval' => $max_interval,
                'index' => $index,
                'cur_real_index' => $cur_real_index,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ],
            'cate' => $cate,
        ]);

    }
}
