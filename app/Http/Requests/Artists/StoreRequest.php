<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Artists;
use App\Http\Requests\Request;

class StoreRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        return [
            'artist_title' => 'string|required|unique:artists',
            'artist_name' => 'string|required|unique:artists',
            'artist_info' => 'string|required|min:10',
            'artist_birthday' => 'required',
            'artist_gender' => 'integer|required',
            'artist_nation' => 'integer|required',
            'artist_img_small' => 'required|mimetypes:image/jpeg,image/png',
            'artist_img_cover' => 'required|mimetypes:image/jpeg,image/png'
        ];
    }
}