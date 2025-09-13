<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //

    protected $fillable = ['title', 'slug', 'description', 'question'];
    protected $dates = ['created_at', 'updated_at'];
}
