<?php
namespace Forms\Field;

use Forms\Field\Field;

class CheckboxField extends Field
{
    
    public function getBody()
    {
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue() ? 'checked' : '';
        $label  = $this->getLabel();
        
        return "<label for=\"$id\" >$label</label> <input type=\"checkbox\" name=\"$name\" id=\"$id\" $value />";
    }
    
    

    public function getFieldName()
    {
        return 'checkbox';
    }
}