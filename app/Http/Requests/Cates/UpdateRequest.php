<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Cates;
use App\Http\Requests\Request;

class UpdateRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        $id = $this->segment(2);
        return [
            'cate_title' => 'required|unique:cates,cate_title,' . $id,
            'cate_chart' => 'required|integer',
            'cate_parent' => 'required|integer'
        ];
    }
}