<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = ['created_at', 'deleted_at', 'updated_at'];
    public function posts(){
        return $this->belongsToMany(Post::class);
    }
    use HasFactory;
}
