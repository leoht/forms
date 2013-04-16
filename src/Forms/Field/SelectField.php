<?php
namespace Forms\Field;

use Forms\Field\Field;

class SelectField extends Field
{
    
    protected $multiple = false;
    
    protected $options = array();
    
    public function setMultiple()
    {
        $this->multiple = true;
        
        return $this;
    }
    
    public function getBody()
    {
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue();
        $label  = $this->getLabel();
        
        $options = '';
        
        $multiple = $this->multiple ? 'multiple' : '';
        $required = $this->hasRule('not_empty') ? 'required' : '';
        
        foreach($this->options as $opt_value => $opt_label) {
            $options .= "<option value=\"$opt_value\" >$opt_label</option>";
        }
        return "<label for=\"$id\" >$label</label> <select $required $multiple name=\"$name\" id=\"$id\" >
                    $options \r\n
                </select>";
    }
    
    public function addOption($value, $label)
    {
        $this->options[$value] = $label;
        
        return $this;
    }
    

    public function getFieldName()
    {
        return 'select';
    }
}