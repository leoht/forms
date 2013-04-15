<?php
namespace Forms\Field;

use Forms\Field\Field;

class SubmitField extends Field
{
    
    public function __construct($value)
    {
        $this->value = $value;
    }
    
    public function getBody()
    {
        $value  = $this->getValue();
        
        return "<input type=\"submit\" value=\"$value\" />";
    }

    public function getFieldName()
    {
        return 'submit';
    }
    
    public function addRules()
    {
        throw new \LogicException("Rules cannot be added on a submit field");
    }
}