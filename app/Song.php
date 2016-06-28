<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected  $fillable = ['song_title','song_view','song_mp3'];
	protected $appends = ['song_artists_id','song_artists_title'];

	public function cate()
	{
		return $this->belongsTo(Cate::class);
	}
	public function artists()
	{
		return $this->belongsToMany(Artist::class);
	}
	public function playlists()
	{
		return $this->belongsToMany(Playlist::class);
	}
	public function lyrics()
	{
		return $this->hasMany(Lyric::class);
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
	public function getSongArtistsTitleAttribute()
	{
		$song_artists = $this->artists;
		$str_song_artists = '';
		foreach ($song_artists as $song_artist)
		{
			$str_song_artists .= $song_artist->artist_title.' ';
		}
		return $str_song_artists;
	}
	public function getSongArtistsIdAttribute()
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
