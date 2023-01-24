<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'main_link',
        'encoded_url',
        'transformed_link'
    ];

    public function getFulladdressAttribute()
    {
        return $_SERVER['HTTP_HOST'].$this->transformed_link;
    }
}
