<?php
namespace Forms\Field;

use Forms\Validation\Validator;
use Forms\Validation\Rule\Rule;

/**
 * An abstract field type
 * 
 * @author Léo Hetsch
 * @abstract 
 */
abstract class Field
{
    /**
     * @var string 
     */
    protected $name;
    
    /**
     * @var string 
     */
    protected $id;
    
    /**
     * @var string 
     */
    protected $label;
    
    /**
     * @var string 
     */
    protected $value;
    
    /**
     * @var array 
     */
    protected $rules;
    
    /**
     * @var array
     */
    protected $attributes;
    
    /**
     * @var array 
     */
    protected $builder_configuration;
    
    /**
     * Constructor
     * 
     * @param string $name
     * @param string $label
     * @param string $id
     * @param string $value
     * @param array $builder_configuration 
     */
    public function __construct($name, $label = null, $id = null, $value = null, array $builder_configuration = array())
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id != null ? $id : $name;
        $this->value = $value;
        $this->rules = array();
        $this->attributes = array();
        $this->builder_configuration = $builder_configuration;
                
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function setLabel($label)
    {
        $this->label = $label;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    public function addRule(Rule $rule)
    {
        $this->rules[$rule->getName()] = $rule;

        return $this;
    }
    
    /**
     * Add validation rules to the field
     * 
     * @param array $rules
     * @return \Forms\Field\Field
     * @throws \RuntimeException if the rule doesn't exist
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $name => $value) {
            if (Validator::hasRule($name)) {
                $rule = Validator::getRule($name);
                $rule->setValue($value);
                $this->addRule($rule);
            } else {
                throw new \RuntimeException(sprintf("The rule '%s' doest not exist.", $name));
            }
        }
        
        return $this;
    }
    
    public function getRules()
    {
        return $this->rules;
    }
    
    /**
     * Get the field attributes
     * @return array 
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    
    /**
     * Add an attribute to the field
     * @param string $name
     * @param string $value 
     */
    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }
    
    public function getFormattedAttributes()
    {
        $attributes = $this->getAttributes();
        $formatted = ' ';
        foreach($attributes as $name => $value) {
            $formatted .= $name.' = "'.$value.'" ';
        }
        
        return $formatted;
    }
    
    /**
     * Get the serialized rules array (used for saving rules in a hidden input)
     * 
     * @return type 
     */
    public function getRulesSerialized()
    {
        $rules = $this->getRules();
        $array = array();
        foreach($rules as $name => $rule) {
            $array[$name] = is_array($rule->getValue()) ? serialize($rule->getValue()) : $rule->getValue();
        }
        
        return serialize($array);
    }
    
    /**
     * Unserialize the rules array
     * 
     * @param string $serialized_rules
     * @return \Forms\Field\Field 
     */
    public function unserializeRules($serialized_rules)
    {
        $rules = unserialize($serialized_rules);
        
        foreach($rules as $name => $value) {
            if (@unserialize($value)) {
                $rules[$name] = @unserialize($value);
            }
        }
        
        $this->addRules($rules);

        return $this;
    }
    
    /**
     * Check if the field has validation rules
     * @return boolean 
     */
    public function hasRules()
    {
        return 0 != count($this->getRules());
    }
    
    /**
     * Check if the field has a validation rule
     * @param string $name the name of the rule
     * @return boolean 
     */
    public function hasRule($name)
    {
        return array_key_exists($name, $this->getRules());
    }
    
    abstract public function getFieldName();
    
    abstract public function getBody();

    /**
     * Get the body of the hidden input that stores the rules
     * 
     * @return string 
     */
    public function getRuleBody()
    {
        $name = $this->getName();
        $value = $this->getRulesSerialized();
        
        return "<input type=\"hidden\" name=\"_rules_$name\" value='$value' />";
    }
    
    /**
     * Get the body of the hidden input that stores field metadata
     * 
     * @return string 
     */
    public function getMetadataBody()
    {
        $name = $this->getName();
        $type = $this->getFieldName();
        
        return "<input type=\"hidden\" name=\"_type_$name\" value=\"$type\" />";
    }
    
    /**
     * Get the builder configuration array
     * 
     * @return array 
     */
    public function getBuilderConfiguration()
    {
        return $this->builder_configuration;
    }
    
}