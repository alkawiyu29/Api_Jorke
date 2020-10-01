<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $hidden = ['created_at','updated_at'];

    public function book()
    {
        return $this->belongsToMany('App\Book', 'categories');
    }
}
