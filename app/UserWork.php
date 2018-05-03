<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWork extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'time','date', 'status'
    ];



}
