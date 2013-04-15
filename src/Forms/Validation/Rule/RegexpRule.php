<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

class RegexpRule extends Rule
{
    public function getName()
    {
        return 'regexp';
    }
    
    public function isValueValid($value)
    {
        return is_string($value);
    }
    
    public function getExpectedValueType()
    {
        return 'string';
    }
    
    public function isFieldValid(Field $field)
    {
        $regexp = $this->getValue();
        
        return preg_match("#$regexp#", $field->getValue());
    }
    
}