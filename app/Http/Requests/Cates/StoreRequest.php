<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Cates;
use App\Http\Requests\Request;

class StoreRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'cate_title' => 'required|unique:cates,cate_title',
            'cate_chart' => 'required|integer',
            'cate_parent' => 'required|integer'
        ];
    }
}