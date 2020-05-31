<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occasions extends Model
{
	protected $fillable = [
        'name_occasion', 'name_owner', 'date','time','address' , 'lng' ,'lat',
        'section_id' , 'user_id' ,'is_accepted','is_public' ,'invitationUser_id','check_manger','image'

    ];
   public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function admin()
    {
        return $this->belongsTo('App\User');
    }
   public function section()
    {
        return $this->belongsTo('App\Section');
    }
    public function invitationUser()
    {
        return $this->belongsToMany('App\User','occasions_users');
    }  
    public function notification(){
        return $this->hasMany('App\Notification');
    }
 }