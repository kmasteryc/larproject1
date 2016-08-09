<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public $timestamps = false;
    public $fillable = ['viewable_type','viewable_id','view_date','view_count'];
    public function viewable()
    {
        return $this->morphTo();
    }
}
