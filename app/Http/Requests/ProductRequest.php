<?php

namespace App\Http\Requests;

use App\Rules\ProductQty;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'slug' => 'required|unique:products,slug,'.$this->id,
            'description' => 'required|max:1000',
            'short_description' => 'nullable|max:500',
            'categories' => 'array|min:1', //[]
            'categories.*' => 'numeric|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'brand_id' => 'required|exists:brands,id',
            'price'=>'required|numeric|min:0',
            'special_price'=>'nullable|numeric|lt:price',
            'special_price_type'=>'required_with:special_price|in:fixed,percent',
            'special_price_start'=>'required_with:special_price|date_format:Y-m-d|before_or_equal:special_price_end',
            'special_price_end'=>'required_with:special_price|date_format:Y-m-d|after_or_equal:special_price_start',
            'sku'=>'nullable|min:4|max:16',
            'manage_stock'=>'required|in:0,1',
            'in_stock'=>'required|in:0,1',
//            'qty'=>'required_if:manage_stock,==,1|in:0,1',
            'qty'=>[new ProductQty($this->manage_stock)],

        ];
    }

}
