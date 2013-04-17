<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

/**
 * InRule :
 * Field value must be in an array of values 
 */
class InRule extends Rule
{
    public function getName()
    {
        return 'in';
    }
    
    public function isValueValid($value)
    {
        return is_array($value);
    }
    
    public function getExpectedValueType()
    {
        return 'array';
    }
    
    public function isFieldValid(Field $field)
    {
        return in_array($field->getValue(), $this->getValue());
    }
    
    
}