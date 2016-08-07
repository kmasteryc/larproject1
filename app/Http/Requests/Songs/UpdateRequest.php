<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Songs;
use App\Http\Requests\Request;

class UpdateRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        $id = $this->segment(2);
        return [
            'song_title' => "required|unique:songs,song_title,$id",
            'uploaded_mp3' => 'mimetypes:audio/mpeg',
            'cate_id' => 'required|integer',
            'song_artists' => 'required'
        ];
    }
}