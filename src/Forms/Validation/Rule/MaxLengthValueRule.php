<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

class MaxLengthValueRule extends Rule
{
    public function getName()
    {
        return 'maxlength';
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
        return $this->getValue() > strlen($field->getValue());
    }
    
}