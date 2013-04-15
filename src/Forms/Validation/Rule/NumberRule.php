<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

class NumberRule extends Rule
{
    public function getName()
    {
        return 'number';
    }
    
    public function isValueValid($value)
    {
        return is_bool($value);
    }
    
    public function getExpectedValueType()
    {
        return 'boolean';
    }
    
    public function isFieldValid(Field $field)
    {
        if (true !== $this->getValue()) {
            return true;
        }
        
        return is_numeric($field->getValue()) || preg_match('#^[0-9]+$#', $field->getValue());
    }
    
}