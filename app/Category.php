<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','name_ar','name_sw', 'slug'];

    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function subcategories()
    {
    	return $this->hasMany(SubCategory::class);
    }

    public function products()
    {
    	return $this->hasMany(Product::class);
    }
}
