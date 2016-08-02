<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    protected  $fillable = ['lyric_content'];
    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
