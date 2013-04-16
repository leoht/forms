<?php
namespace Forms\Field;

use Forms\Field\Field;

class ChoiceField extends Field
{
    
    protected $choices = array();
    
    public function addChoice($value, $label)
    {
        $this->choices[$value] = $label;
        
        return $this;
    }
    
    public function getBody()
    {
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue() ? 'checked' : '';
        $label  = $this->getLabel();
        
        $config = $this->getBuilderConfiguration();
        $required = $this->hasRule('not_empty') && $config['html5_required'] ? 'required' : '';
        
        $body = "$label ";
        foreach($this->choices as $opt_value => $opt_label) {
            $body .= "<input $required type=\"radio\" name=\"$name\" value=\"$opt_value\" id=\"{$name}_{$opt_value}\" > <label for=\"{$name}_{$opt_value}\" >$opt_label</label>";
        }
        
        return $body;
    }
    
    

    public function getFieldName()
    {
        return 'choice';
    }
}