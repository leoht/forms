<?php
namespace Forms\Field;

use Forms\Field\Field;

/**
 * A "submit" button 
 */
class SubmitField extends Field
{
    
    
    public function __construct($value)
    {
        $this->value = $value;
        $this->rules = array();
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
    
    /**
     * {@inheritdoc} 
     * Overriden to avoid adding rules on the submit field, which is non sense.
     * @throws \LogicException
     */
    public function addRules()
    {
        throw new \LogicException("Rules cannot be added on a submit field");
    }
}