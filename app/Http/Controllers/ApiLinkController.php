<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Hashids\Hashids;
use Illuminate\Support\Facades\Redis;

class ApiLinkController extends Controller
{
    public function store()
    {
        $main_link = request('main_link');

        $link = new Link();
        $link->main_link = $main_link;
        $link->save();

        $_id = $link->id;
        $hashids = new Hashids('',5);
        $_id = $hashids->encode($_id);
        $link->encoded_url = $_id;
        $link->transformed_link = $_SERVER['HTTP_HOST'].'/links/'.$_id;
        $link->update();

        return Link::all();
    }


    public function index()
    {
        $links = Link::all();
        $final_links = [];

        foreach($links as $link)
        {
            $click_count_string = 'click_count:'.(Redis::get('link:'.$link->id.':click_count') ?? 0);
            $link_string = $link->transformed_link;
            $final_links[] = [$link_string,$click_count_string];
        }

        return $final_links;
    }
    

    public function sort()
    {
        $number = request('number');
        $counters_array = [];

        for($i=0 ; $i <100 ; $i++){

                $count = Redis::get('link:'.$i.':click_count');
                
                if(!$count){
                    continue;   
                } 
                $counters_array[$i] = $count ;                  
        }

        $max_array = [];

        for($i=0; $i<$number; $i++){

            $max = max($counters_array);
            $key = array_search($max, $counters_array); 
            
            unset($counters_array[$key]);
        
            $max_array[$key] = $max;
        }

        $top_links = [];

        foreach($max_array as $key => $value)
        {
            $link = Link::find($key);
            $top_links[] = [$link , 'click_count:'.$value];
        }
        
        return $top_links;
    }



}
