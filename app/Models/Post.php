<?php

namespace App\Models;
use\App\Models\Catregory;
use\App\Models\userLogin;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['created_at', 'updated_at'];

    protected $dates = [
        'published_at',
    ];
    public function category(){
        return $this->belongsTo('App\Models\Catregory');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
    use HasFactory;
}
