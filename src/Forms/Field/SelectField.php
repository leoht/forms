<?php
namespace Forms\Field;

use Forms\Field\Field;

class SelectField extends Field
{
    
    protected $multiple = false;
    
    protected $options = array();
    
    public function addOption($value, $label, $default = false)
    {
        $this->options[$value] = array(
                                        'label' => $label,
                                        'default' => $default
                                        );
        
        return $this;
    }
    
    
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
        
        $options = '<option value="" ></option>';
        
        $multiple = $this->multiple ? 'multiple' : '';
        $required = $this->hasRule('not_empty') ? 'required' : '';
        
        foreach($this->options as $opt_value => $opt) {
            $opt_label = $opt['label'];
            $selected = $opt['default'] == true ? 'selected="selected"' : '';
            $options .= "<option value=\"$opt_value\" $selected >$opt_label</option>";
        }
        return "<label for=\"$id\" >$label</label> <select $required $multiple name=\"$name\" id=\"$id\" >
                    $options \r\n
                </select>";
    }
    
    

    public function getFieldName()
    {
        return 'select';
    }
}