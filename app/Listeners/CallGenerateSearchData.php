<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 09/08/2016
 * Time: 09:52
 */

namespace App\Listeners;

use Illuminate\Support\Facades\Artisan;

class CallGenerateSearchData
{
    public function handle(){
        Artisan::call('db:dump_data');
    }
}