<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Cate;
use Illuminate\Support\Facades\Auth;

class CatePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	public function delete(Cate $cate){


	}
}
