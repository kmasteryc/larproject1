<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected  $fillable = ['song_title','song_view','song_mp3'];
//	protected $prepends = ['song_artists_id','song_artists_title','song_artists_title_text'];
//	protected $appends = ['song_artists_id','song_artists_title','song_artists_title_text'];
//	protected $appends = ['song_artists_id'];

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
	public function views()
	{
		return $this->morphMany(View::class,'viewable');
	}
//	public function str_artists()
//	{
//		$song_artists = $this->artists;
//		$str_song_artists = '';
//		foreach ($song_artists as $song_artist)
//		{
//			$str_song_artists .= $song_artist->id.',';
//		}
//		return $str_song_artists;
//	}
//	public function getSongArtistsTitleAttribute()
//	{
//		$song_artists = $this->artists;
//		$str_song_artists = '';
////		$total = count($song_artists);
//		foreach ($song_artists as $song_artist)
//		{
//			$str_song_artists .= '<a href="'.url('artist/'.$song_artist->id).'">'.$song_artist->artist_title.'</a> ';
//		}
//		return $str_song_artists;
//	}
//	public function getSongArtistsTitleTextAttribute()
//	{
//		$song_artists = $this->artists;
//		$str_song_artists = '';
////		$total = count($song_artists);
//		foreach ($song_artists as $song_artist)
//		{
//			$str_song_artists .= $song_artist->artist_title;
//		}
//		return $str_song_artists;
//	}
//	public function getSongArtistsIdAttribute()
//	{
//		$song_artists = $this->artists()->select('artists.id')->get();
//		$str_song_artists = '';
//		foreach ($song_artists as $song_artist)
//		{
//			$str_song_artists .= $song_artist->id.',';
//		}
//		return $str_song_artists;
//	}

//	public function getSongImgAttribute($value){
//		return $value?:"http://image.mp3.zdn.vn/cover3_artist/f/b/fb32b1dce0d8487b0916284892123f79_1459843495.jpg";
//	}

}
