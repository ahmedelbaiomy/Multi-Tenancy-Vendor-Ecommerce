<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory,Translatable,SoftDeletes;
    protected $with = ['translations'];

    protected $fillable =
    [
        'brand_id',
        'slug',
        'sku',
        'price',
        'special_price',
        'special_price_type',
        'special_price_start',
        'special_price_end',
        'selling_price',
        'manage_stock',
        'qty',
        'in_stock',
        'is_active',
    ];

    protected $casts=[
        'manage_stock'=>'boolean',
        'in_stock'=>'boolean',
        'is_active'=>'boolean',
    ];

    protected $dates = [
        'special_price_start',
        'special_price_end',
        'start_date',
        'end_date',
        'deleted_at',
    ];

    protected $translatedAttributes = ['name','description','short_description'];

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','id')->withDefault();
    }
    public function categories(){
        return $this->belongsToMany(Category::class,'product_categories','product_id','category_id')->withPivot('category_id');;
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,'product_tags','product_id','tag_id');
    }
    public function wishlist(){
        return $this->belongsToMany(User::class,'wishlist','product_id','user_id');
    }

    public function getActive()
    {
        return $this->is_active == 0 ? __('admin\dashboard.not active') : __('admin\dashboard.active');
    }
    public function scopeActive($query){
        return $query->where('is_active',1);
    }
    public function options(){
        return $this->hasMany(Option::class);
    }

    public function images(){
        return $this->hasMany(Image::class,'product_id');
    }
    public function price():Attribute
    {
        return Attribute::make(
            get: fn($val) =>number_format($val,2),
        );
    }
    public function SpecialPrice():Attribute
    {
        return Attribute::make(
            get: fn($val) =>number_format($val,2),
        );
    }

//    public function Photo():Attribute
//    {
//        return Attribute::make(
//            get: fn($val) => asset('assets/images/products/' . $val),
//        );
//    }

}
