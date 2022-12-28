<?php

namespace App\Http\Requests;

use App\Http\Enumerations\CategoryType;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name'=>'required',
            'type'=>'required|in:'.CategoryType::mainCategory.','.CategoryType::subCategory.'',
            'slug'=>'required|unique:categories,slug,'.$this->id,
        ];
    }

}
