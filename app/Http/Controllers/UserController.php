<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use App\User;
use App\Http\Requests;

use App\Http\Requests\Users\UpdateRequest;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'myjs' => ['jquery.dynatable.js'],
            'mycss' => ['jquery.dynatable.css'],
            'users' => User::all(),
            'cp' => true
        ]);
    }

    public function delete(User $user, Request $request)
    {
        if (!Gate::check('is-admin')) abort(404);

        $user->delete();

        $request->session()->flash('succeeds', 'Your done!');
        return back();
    }

    public function create()
    {
        return redirect('auth/login');
    }

    public function edit(User $user)
    {
        $playlists = \App\Playlist::where('user_id',$user->id)->withCount('songs')->paginate(10);

        return view('users.edit', [
            'myjs' => ['jquery.dynatable.js'],
            'mycss' => ['jquery.dynatable.css'],
            'user' => $user,
            'playlists' => $playlists,
            'cp' => true
        ]);
    }

    public function update(UpdateRequest $request, User $user)
    {
        if ($request->has('password')){
            $user->password = Hash::make($request->password);
        }
        $user->name = $request->name;
        $user->level = $request->level;
        $user->email = $request->email;
        $user->save();

        $request->session()->flash('succeeds', 'Your done!');
        return back();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_title' => 'string|required|unique:users',
            'user_name' => 'string|required|unique:users',
            'user_info' => 'string|required|min:10',
            'user_birthday' => 'required',
            'user_gender' => 'integer|required',
            'user_nation' => 'integer|required',
            'user_img_small' => 'required|mimetypes:image/jpeg,image/png',
            'user_img_cover' => 'required|mimetypes:image/jpeg,image/png'
        ]);

//        if (!$request->file('user_img_small')->isValid() || $request->file('user_img_cover')->isValid()){
//            return back()->withErrors('Upload Images Error!');
//        }

        $user_img_small = $request->file('user_img_small');
        $user_img_cover = $request->file('user_img_cover');
        $user_img_small_name = rand(1, 99999999) . $user_img_small->getClientOriginalName();
        $user_img_cover_name = rand(1, 99999999) . $user_img_cover->getClientOriginalName();
        $user_img_small->move(base_path('public/uploads/imgs/users/'), $user_img_small_name);
        $user_img_cover->move(base_path('public/uploads/imgs/users/'), $user_img_cover_name);

        // After uploading was done. Do insert info to DB
        $user_img_small_link = asset('uploads/imgs/users/' . $user_img_small_name);
        $user_img_cover_link = asset('uploads/imgs/users/' . $user_img_cover_name);

        $user = new User;

        $user->user_title = $request->input('user_title');
        $user->user_title_slug = str_slug($user->user_title);
        $user->user_title_eng = str_replace('-', ' ', $user->user_title_slug);
        $user->user_name = $request->input('user_name');
        $user->user_info = $request->input('user_info');
        $user->user_birthday = $request->input('user_birthday');
        $user->user_gender = $request->input('user_gender');
        $user->user_nation = $request->input('user_nation');
        $user->user_img_small = $user_img_small_link;
        $user->user_img_cover = $user_img_cover_link;

        $user->save();
        $request->session()->flash('succeeds', 'Your done!');
        return redirect('user');
    }
}
