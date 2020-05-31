<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
      protected $table = 'codes';
     protected $fillable = [
        'name','phone','code'
    ];
     public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}