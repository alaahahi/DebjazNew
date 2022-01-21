<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categore extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function posts()
    {
        return $this->hasMany(Post::class,'categore_id','id');
    }
}
