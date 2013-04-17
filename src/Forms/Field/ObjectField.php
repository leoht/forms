<?php
namespace Forms\Field;

use Forms\Field\Field;
use Forms\Field\TextField;

class ObjectField extends Field
{
    protected $fields;
    
    public function __construct($name, $label = null, $id = null, $value = null, array $builder_configuration = array())
    {
        if ( $value && !is_object($value) ) {
            throw new \InvalidArgumentException("Value of field type 'object' must be an object");
        }
        
        parent::__construct($name, $label, $id, $value, $builder_configuration);
        
        $value = $value ? $value : new \stdClass();
        
        foreach(get_object_vars($value) as $name => $value) {
            $this->addField($name, ucfirst($name). ' : ', $this->getId().'_'.$name, $value, $builder_configuration);
        }
        
    }
    
    public function setValue($value)
    {
        if ( $value && !is_object($value) ) {
            throw new \InvalidArgumentException("Value of field type 'object' must be an object");
        }
        
        parent::setValue($value);
        
        $value = $value ? $value : new \stdClass();
        
        foreach(get_object_vars($value) as $name => $value) {
            $this->addField($name, ucfirst($name). ' : ', $this->getId().'_'.$name, $value, $builder_configuration);
        }
    }
    
    public function addField($name, $label, $id, $value, $builder_configuration = array())
    {
        $this->fields[$name] = new TextField($name, $label, $id, $value, $builder_configuration);
    }
    
    public function hasField($name)
    {
        return array_key_exists($name, $this->fields);
    }
    
    public function getField($name)
    {
        return $this->fields[$name];
    }
    
    public function setAttributeLabel($name, $label)
    {
        if ($this->hasField($name)) {
            $this->getField($name)->setLabel($label);
        }
        
        return $this;
    }
    
    public function setAttributeRules($name, array $rules)
    {
        if ($this->hasField($name)) {
            $this->getField($name)->addRules($rules);
        }
        
        return $this;
    }
    
    public function getBody()
    {
        if (empty($this->fields)) return;
        
        $body = '';
        
        foreach($this->fields as $field) {
            $body .= $field->getBody(). "\r\n". $field->getRuleBody() . "\r\n" . $field->getMetadataBody() . " <br />";
        }
        
        return $body;
    }
    
    public function getFieldName()
    {
        return 'object';
    }
}