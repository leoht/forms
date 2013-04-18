<?php
namespace Forms\Field;

use Forms\Field\Field;
use Forms\Field\TextField;

/**
 * The ObjectField builds a subform with one field for each public attribute of the given object
 * 
 * @author Leo Hetsch 
 */
class ObjectField extends Field
{
    /**
     * @var array
     */
    protected $fields;
    
    /**
     * Constructor
     * 
     * @see Forms\Field\Field::__construct
     */
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
    
    /**
     * Override setValue() method to check if the value is an object.
     * 
     * @see Forms\Field\Field::setValue 
     */
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
    
    /**
     * Add a field
     * 
     * @param string $name
     * @param string $label
     * @param string $id
     * @param string $value
     * @param array $builder_configuration 
     */
    public function addField($name, $label, $id, $value, $builder_configuration = array())
    {
        $this->fields[$name] = new TextField($name, $label, $id, $value, $builder_configuration);
        
        return $this;
    }
    
    /**
     * @param string $name
     * @return Boolean 
     */
    public function hasField($name)
    {
        return array_key_exists($name, $this->fields);
    }
    
    /**
     * @param string $name
     * @return Forms\Field\Field 
     */
    public function getField($name)
    {
        return $this->fields[$name];
    }
    
    /**
     * Set the label for an attribute field
     * 
     * @param string $name the attribute name
     * @param string $label the label
     * @return \Forms\Field\ObjectField 
     */
    public function setAttributeLabel($name, $label)
    {
        if ($this->hasField($name)) {
            $this->getField($name)->setLabel($label);
        }
        
        return $this;
    }
    
    /**
     * Set the rules for an attribute field
     * 
     * @param string $name the attribute name
     * @param array $rules
     * @return \Forms\Field\ObjectField 
     */
    public function setAttributeRules($name, array $rules)
    {
        if ($this->hasField($name)) {
            $this->getField($name)->addRules($rules);
        }
        
        return $this;
    }
    
    /**
     * Tells the object field to ignore one attribute of the given object
     * @param string $attribute 
     */
    public function ignoreAttribute($attribute)
    {
        if ($this->hasField($attribute)) {
            unset($this->fields[$attribute]);
        }
    }
    
    /**
     * Clone of ignoreAttribute() but for an array of attributes
     * @see ignoreAttribute
     * @param array $attributes
     */
    public function ignoreAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if ($this->hasField($attribute)) {
                unset($this->fields[$attribute]);
            }
        }
    }
    
    /**
     * Get the field body with all the attribute fields
     * @return string 
     */
    public function getBody()
    {
        if (empty($this->fields)) return;
        
        $body = '';
        
        foreach($this->fields as $field) {
            $body .= $field->getBody(). "\r\n". $field->getRuleBody() . "\r\n" . $field->getMetadataBody() . " <br />";
        }
        
        return $body;
    }
    
    /**
     * Get the field type name
     * @return string 
     */
    public function getFieldName()
    {
        return 'object';
    }
}