<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory, Translatable;

    protected $fillable = ['is_active','photo'];
    protected $translatedAttributes = ['name'];

    protected $hidden = ['translations'];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActive()
    {
        return $this->is_active == 0 ? __('admin\dashboard.not active') : __('admin\dashboard.active');
    }

    public function getPhotoAttribute($photo){
        return ($photo !== null) ? asset('/assets/images/brands/'.$photo) : '';
    }
}
