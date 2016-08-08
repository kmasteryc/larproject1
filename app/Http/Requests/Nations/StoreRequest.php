<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Nations;
use App\Http\Requests\Request;

class StoreRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'nation_title' => 'required|unique:nations,nation_title',
            'id' => 'required|integer|unique:nations,id',
        ];
    }
}