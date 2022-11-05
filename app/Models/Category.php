<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,Translatable;
    protected $fillable=['parent_id','slug','is_active'];
    protected $with = ['translations'];
    protected $translatedAttributes = ['name'];

    protected $hidden = ['translations'];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
