<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone','section_id','code_id','is_active','api_token','device_token','code','google_id','image','code_job'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
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
     public function invitationOccasions()
    {
        return $this->belongsToMany('App\Occasions');
    } 
      public function code()
    {
        return $this->hasOne('App\Code');
    }
}