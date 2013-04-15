<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

class MinValueRule extends Rule
{
    public function getName()
    {
        return 'min';
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
        return $this->getValue() < $field->getValue();
    }
    
}