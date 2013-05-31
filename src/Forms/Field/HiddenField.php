<?php
namespace Forms\Field;

use Forms\Field\Field;

/**
 * Simple hidden field type 
 */
class HiddenField extends Field
{
    
    public function getBody()
    {
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue();
        $label  = $this->getLabel();
        
        $config = $this->getBuilderConfiguration();
        $required = $this->hasRule('not_empty') && $config['html5_required'] ? 'required' : '';
        
        return "<input type=\"hidden\" name=\"$name\" id=\"$id\" value=\"$value\" $required />";
    }
    
    

    public function getFieldName()
    {
        return 'hidden';
    }
}