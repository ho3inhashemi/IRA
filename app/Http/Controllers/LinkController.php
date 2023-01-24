<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Models\Link;

class LinkController extends Controller
{
    public function show(Link $link)
    {
        $counter = Redis::get('link:'.$link->id.':click_count');
        ++$counter;
            
        if($counter == null){
            $counter = 0;
        }

        Redis::set('link:'.$link->id.':click_count', $counter);

        return redirect($link->main_link);
    }

}