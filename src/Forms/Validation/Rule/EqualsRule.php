<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

class EqualsRule extends Rule
{
    public function getName()
    {
        return 'equals';
    }
    
    public function isValueValid($value)
    {
        return is_numeric($value) || is_string($value);
    }
    
    public function getExpectedValueType()
    {
        return 'string';
    }
    
    public function isFieldValid(Field $field)
    {
        return $this->getValue() == $field->getValue();
    }
    
}