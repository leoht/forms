<?php
namespace Forms\Field;

use Forms\Field\Field;

/**
 * A field type for an email adress.
 * Validity of the email adress will be automatically checked while submitting the form. 
 */
class EmailField extends Field
{
    
    public function __construct($name, $label = null, $id = null, $value = null)
    {
        parent::__construct($name, $label, $id, $value);
        
        // adding the regexp rule to check the email adress
        $this->addRules(array(
            'regexp' => '^[A-Za-z0-9._+-]+@[A-Za-z0-9.-]+\.(([A-Za-z]{2})|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$'
        ));
    }
    
    
    public function getBody()
    {
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue();
        $label  = $this->getLabel();
        
        $required = $this->hasRule('not_empty') ? 'required' : '';
        
        return "<label for=\"$id\" >$label</label> <input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" $required />";
    }
    
    

    public function getFieldName()
    {
        return 'email';
    }
}