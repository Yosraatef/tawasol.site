<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Admin extends Authenticatable
{
   use Notifiable;
   protected $guard = 'admin';
   protected $table = 'users';
    protected $fillable = [
        'name', 'phone','section_id','code_id','is_active','api_token','device_token','code','google_id','image','code_job'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function section()
    {
        return $this->belongsTo('App\Section');
    }
     public function occasions(){
        return $this->hasMany('App\Occasions');
    }
}