<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Faker;
use Carbon\Carbon;
use GuzzleHttp;

class Artist extends Model
{
    protected $fillable = ['artist_title','artist_name','artist_info','artist_birthday','artist_gender','artist_nation'];
	public $timestamps = false;

	public function getArtistGenderAttribute($value)
	{
		return $value == 1 ? "Nam" : "Nữ";
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

    public function getArtistBirthdayFormatedAttribute()
    {
        $dt = Carbon::createFromFormat('Y-m-d',$this->attributes['artist_birthday']);
        return $dt->format('d/m/Y');
    }
    public function getArtistBirthdaydAttribute($value)
    {
        $dt = Carbon::createFromFormat('Y-m-d',$value);
        return $dt->format('m/d/Y');
    }

    public function nation(){
        return $this->belongsTo(Nation::class);
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
    public static function createNewArtist($artist_title)
    {
//        dd($artist_title);
        $faker = Faker\Factory::create();
        $artist = new Artist;

        $artist->artist_title = $artist_title;
        $artist->artist_title_eng = str_replace('-',' ',str_slug($artist_title));
        $artist->artist_title_slug = str_slug($artist_title);
        $artist->artist_name = $artist_title;
        $artist->artist_info = $faker->sentence(200);
        $artist->artist_birthday = $faker->dateTimeThisCentury->format('Y-m-d');
        $artist->artist_gender = rand(0, 1);
        $artist->artist_nation = rand(0, 256);

        $url = "http://mp3.zing.vn/nghe-si/" . str_slug($artist->artist_title);

        $client = new GuzzleHttp\Client();
        try {
            $res = $client->request('GET', $url);

            if ($res->getStatusCode() == 200) {
                if ($res->getBody() != '') {
                    preg_match_all('/container">         <img src="([^"]+)"/', $res->getBody(), $match1);
                    preg_match_all('/<div class="inside">.*src="([^"]+)"/', $res->getBody(), $match2);

                    $cover_img = $match1[1][0];
                    $small_img = $match2[1][0];
                    $cover_img_name = rand(1, 999999) . basename($cover_img);
                    $small_img_name = rand(1, 999999) . basename($cover_img);

                    $cover_path = base_path('public/uploads/imgs/artists/' . $cover_img_name);
                    $small_path = base_path('public/uploads/imgs/artists/' . $small_img_name);

                    file_put_contents($cover_path, file_get_contents($cover_img));
                    file_put_contents($small_path, file_get_contents($small_img));

                    $artist->artist_img_small = asset('uploads/imgs/artists/' . $small_img_name);
                    $artist->artist_img_cover = asset('uploads/imgs/artists/' . $cover_img_name);
                    $artist->save();
                }
                else{
                    $artist = '';
                }

            }
        } catch (\Exception $e) {
            echo $e;
        }

        return $artist;
    }
}
