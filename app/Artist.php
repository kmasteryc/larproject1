<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['artist_title','artist_name','artist_info','artist_birthday','artist_gender','artist_nation'];
	public $timestamps = false;

	public function getArtistGenderAttribute($value)
	{
		return $value == 1 ? "Nam" : "Nu";
	}

	public function songs()
	{
		return $this->belongsToMany(Song::class);
	}
}
