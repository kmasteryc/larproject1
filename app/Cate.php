<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cate extends Model
{
//	use SoftDeletes;
	public $timestamps = false;
//	protected $dates = ['deleted_at'];

	protected $fillable = ['cate_title','cate_parent'];

	public function playlists(){
		return $this->belongsToMany(Playlist::class);
	}
	public function songs()
	{
		return $this->hasMany(Song::class);
	}
}
