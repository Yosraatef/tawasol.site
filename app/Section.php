<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
     protected $fillable = [
        'name',
    ];
     public function admin(){
        return $this->hasOne('App\Admin');
    }
     public function user(){
        return $this->hasOne('App\User');
    }
     public function occasions(){
        return $this->hasMany('App\Occasions');
    }
}
