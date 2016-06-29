<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
	protected $fillable = ['playlist_title','playlist_view','user_id','cate_id'];
	protected $appends = ['playlist_songs_id','playlist_songs_title'];

    public function cate()
	{
		return $this->belongsTo(Cate::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function songs()
	{
		return $this->belongsToMany(Song::class);
	}

	public function image()
	{
		return $this->morphOne(Image::class,'imageable');
	}

	public function getPlaylistSongsIdAttribute()
	{
		$playlist_songs = $this->songs;
		$str_playlist_songs = '';
		foreach ($playlist_songs as $playlist_song)
		{
			$str_playlist_songs .= $playlist_song->id.',';
		}
		return $str_playlist_songs;
	}
}
