<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categories;

class Book extends Model
{
    protected $hidden = ['created_at','updated_at'];

    public function rack()
    {
        return $this->belongsTo('App\Rack');
    }
}