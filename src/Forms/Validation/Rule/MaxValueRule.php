<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

/**
 * MaxValueRule :
 * Field value must be lower than a certain value 
 */
class MaxValueRule extends Rule
{
    public function getName()
    {
        return 'max';
    }
    
    public function isValueValid($value)
    {
        return is_numeric($value) || is_string($value);
    }
    
    public function getExpectedValueType()
    {
        return 'number';
    }
    
    public function isFieldValid(Field $field)
    {
        return $this->getValue() > $field->getValue();
    }
    
}