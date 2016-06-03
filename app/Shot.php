<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shot extends Model
{
    protected $fillable = [
        'shot_url', 'shot_download_url', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
