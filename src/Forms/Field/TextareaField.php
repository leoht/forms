<?php
namespace Forms\Field;

use Forms\Field\Field;

class TextareaField extends Field
{
    
    public function getBody()
    {
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue();
        $label  = $this->getLabel();
        
        $config = $this->getBuilderConfiguration();
        $required = $this->hasRule('not_empty') && $config['html5_required'] ? 'required' : '';
        
        return "<label for=\"$id\" >$label</label> <textarea name=\"$name\" id=\"$id\" $required >$value</textarea>";
    }

    public function getFieldName()
    {
        return 'textarea';
    }
    
}