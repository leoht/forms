<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

class NotEmptyRule extends Rule
{
    public function getName()
    {
        return 'not_empty';
    }
    
    public function isValueValid($value)
    {
        return is_bool($value);
    }
    
    public function getExpectedValueType()
    {
        return 'mixed';
    }
    
    public function isFieldValid(Field $field)
    {
        if (true !== $this->getValue()) {
            return true;
        }
        
        return null !== $field->getValue() && '' != $field->getValue();
    }
    
}