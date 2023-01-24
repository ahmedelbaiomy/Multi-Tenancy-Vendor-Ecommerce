<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Slider extends Model
{
    use HasFactory;
    protected $fillable = ['photo'];

//    public function photo():Attribute
//    {
//        return Attribute::make(
//            get: fn($val) => asset('assets/images/sliders/' . $val),
//        );
//    }
}
