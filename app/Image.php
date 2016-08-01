<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function imageable()
	{
		return $this->morphTo();
	}

    public function getImagePathAttribute($value)
    {
        if (!$value)
        {
            $value = 'http://placehold.it/165x165';
        }
        return $value;
    }
}
