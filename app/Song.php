<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected  $fillable = ['song_title','song_view','song_mp3'];

	public function cate()
	{
		return $this->belongsTo(Cate::class);
	}
	public function artists()
	{
		return $this->belongsToMany(Artist::class);
	}
	public function str_artists()
	{
		$song_artists = $this->artists;
		$str_song_artists = '';
		foreach ($song_artists as $song_artist)
		{
			$str_song_artists .= $song_artist->id.',';
		}
		return $str_song_artists;
	}

}
