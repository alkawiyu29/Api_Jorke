<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    protected $hidden = ['created_at','updated_at'];
    
    public function book()
    {
        return $this->belongsTo('App\Book', 'rack_id');
    }
}
