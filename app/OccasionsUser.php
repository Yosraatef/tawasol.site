<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OccasionsUser extends Model
{
     protected $table = 'occasions_users';
     protected $fillable = ['occasions_id','user_id'];
    
}