<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Faker;
use Carbon\Carbon;

class Artist extends Model
{
    protected $fillable = ['artist_title','artist_name','artist_info','artist_birthday','artist_gender','artist_nation'];
	public $timestamps = false;

	public function getArtistGenderAttribute($value)
	{
		return $value == 1 ? "Nam" : "Nu";
	}

    public function getArtistImgSmallAttribute($value)
    {
        if (!$value) $value = 'http://placehold.it/64x64';
        return $value;
    }

    public function getArtistImgCoverAttribute($value)
    {
        if (!$value) $value = 'http://placehold.it/700x300';
        return $value;
    }

    public function getArtistBirthdayAttribute($value)
    {
        $dt = Carbon::createFromFormat('Y-m-d',$value);
        return $dt->format('d/m/Y');
    }

	public function songs()
	{
		return $this->belongsToMany(Song::class);
	}

    public function playlists(){
        return $this->hasMany(Playlist::class);
    }
	public static function createAndAttach($artists_title, Song $song)
	{
        foreach ($artists_title as $artist_title) {
            // If not exist -> create new artist
            if (self::where('artist_title', $artist_title)->first() == '') {
                $faker = Faker\Factory::create();
                $artist = new Artist;
                
                $artist->artist_title = $artist_title;
                $artist->artist_name = $artist_title;
                $artist->artist_info = $faker->sentence(100);
                $artist->artist_birthday = $faker->dateTimeThisCentury->format('Y-m-d');
                $artist->artist_gender = rand(0, 1);
                $artist->artist_nation = rand(0, 256);

                $artist->save();
            }
            // Get artist
            $artist = self::where('artist_title', $artist_title)->first();
            // Attach song to artist
            $song->artists()->attach($artist);
        }
	}
}
