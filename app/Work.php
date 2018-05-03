<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'start', 'end','week_day'
    ];



}
