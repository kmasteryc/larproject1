<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 07/08/2016
 * Time: 10:06
 */
namespace App\Http\Requests\Users;
use App\Http\Requests\Request;

class UpdateRequest extends Request{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        $id = $this->segment(2);
        return [
            'password' => 'min_length[5]',
            'email' => 'required|email|unique:users,email,'.$id,
            'level' => 'required|integer'
        ];
    }
}