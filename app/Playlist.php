<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    public function cates(){
		return $this->belongsToMany(Cate::class);
	}
}
