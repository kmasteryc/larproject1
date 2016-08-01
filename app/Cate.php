<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cate extends Model
{
//	use SoftDeletes;
    public $timestamps = false;
//	protected $dates = ['deleted_at'];

    protected $fillable = ['cate_title', 'cate_parent', 'cate_chart'];

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

//    public static function fromSlug($slug)
//    {
//        return self::where('cate_title_slug',$slug)->first();
//    }
}
