<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'name_ar','name_sw','category_id', 'sub_category_id', 'description','description_ar','description_sw','gift','gift_ar','gift_sw','gift_description','gift_description_ar','gift_description_sw','code', 'image', 'slug', 'quantity', 'price', 'meta_keywords', 'meta_description', 'on_sale', 'is_new','start','end','early','winner','draw_date'];

    /**
    * change key from id to slug
    * @param $slug
    *
    */
    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }

    public function inStock()
    {
        return $this->quantity > 0;
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
