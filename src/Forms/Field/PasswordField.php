<?php
namespace Forms\Field;

use Forms\Field\Field;

class PasswordField extends Field
{
    
    public function getBody()
    {
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue();
        $label  = $this->getLabel();
        
        $required = $this->hasRule('not_empty') ? 'required' : '';
        
        return "<label for=\"$id\" >$label</label> <input type=\"password\" name=\"$name\" id=\"$id\" value=\"$value\" $required />";
    }
    
    

    public function getFieldName()
    {
        return 'password';
    }
}