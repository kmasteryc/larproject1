<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Artists;
use App\Http\Requests\Request;

class UpdateRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        $id = $this->segment(2);
        return [
            'artist_title' => 'string|required|unique:artists,artist_title,' . $id,
            'artist_name' => 'string|required|unique:artists,artist_name,' . $id,
            'artist_info' => 'string|required|min:10',
            'artist_birthday' => 'required',
            'artist_gender' => 'integer|required',
            'nation_id' => 'integer|required',
            'artist_img_small' => 'image',
            'artist_img_cover' => 'image'
        ];
    }
}