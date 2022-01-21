<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function categore(){
        return $this->belongsTo(Categore::class,'categore_id','id');
    }
}
