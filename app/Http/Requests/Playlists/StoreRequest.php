<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Playlists;
use App\Http\Requests\Request;

class StoreRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        return [
            'playlist_title' => 'required|unique:playlists,playlist_title',
            'cate_id' => 'required|integer',
            'playlist_songs' => 'required',
            'playlist_info' => 'string',
            'artist_id' => 'integer|required',
            'playlist_img' => 'required|mimetypes:image/jpeg,image/png'
        ];
    }
}