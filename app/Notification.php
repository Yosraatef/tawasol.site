<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id' ,'content','section_id' ,'occasion_id' ,'is_comment'

    ];
    public function occasions()
    {
        return $this->belongsTo('App\Occasions');
    }
}