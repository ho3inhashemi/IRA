<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'capacity'
    ];

    // You can fill database table subjects using tinker,and below command is a complete example of how to do that.
    // command:
    // DB::table('subjects')->insert(['subject'=>'math','capacity'=>1]);
}
