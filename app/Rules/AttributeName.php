<?php

namespace App\Rules;

use App\Models\AttributeTranslation;
use Illuminate\Contracts\Validation\Rule;

class AttributeName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $attributeName;
    private $attributeId;
    public function __construct($attributeName,$attributeId)
    {
        $this->$attributeName = $attributeName;
        $this->$attributeId = $attributeId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if($this->attributeId){
            $attribute= AttributeTranslation::where('name',$value)->where('attribute_id','!=',$this->attributeId)->first();
        }else{
            $attribute= AttributeTranslation::where('name',$value)->first();
        }

        if($attribute){
           return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This name is already exists';
    }
}
