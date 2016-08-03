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

    public static function getMeAndMyChilds(Cate $parent)
    {
        $childs = Cate::where('cate_parent',$parent->id)->orWhere('id',$parent->id)->pluck('cate_title_slug','id')->toArray();
        return $childs;
    }

//    public static function fromSlug($slug)
//    {
//        return self::where('cate_title_slug',$slug)->first();
//    }
}
