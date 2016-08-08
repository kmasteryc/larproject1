<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Nations;
use App\Http\Requests\Request;

class UpdateRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        $id = $this->segment(2);
        return [
            'nation_title' => "required|unique:nations,nation_title,$id",
            'id' => "required|integer|unique:nations,id,$id",
        ];
    }
}