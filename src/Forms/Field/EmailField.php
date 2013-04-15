<?php
namespace Forms\Field;

use Forms\Field\Field;

class EmailField extends Field
{
    
    public function __construct($name, $label = null, $id = null, $value = null)
    {
        parent::__construct($name, $label, $id, $value);
        
        $this->addRules(array(
            'regexp' => '^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$'
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
        return 'text';
    }
}