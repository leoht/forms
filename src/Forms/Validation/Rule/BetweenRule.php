<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

class BetweenRule extends Rule
{
    public function getName()
    {
        return 'between';
    }
    
    public function isValueValid($value)
    {
        return is_array($value) && count($value) == 2;
    }
    
    public function getExpectedValueType()
    {
        return 'array';
    }
    
    public function isFieldValid(Field $field)
    {
        $between = $this->getValue();
        $min = $between[0] < $between[1] ? $between[0] : $between[1];
        $max = $between[0] > $between[1] ? $between[0] : $between[1];
        
        return $field->getValue() >= $min && $field->getValue() <= $max;
    }
    
}