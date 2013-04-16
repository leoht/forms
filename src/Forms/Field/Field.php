<?php
namespace Forms\Field;

use Forms\Validation\Validator;
use Forms\Validation\Rule\Rule;

abstract class Field
{
    
    protected $name;
    
    protected $id;
    
    protected $label;
    
    protected $value;
    
    protected $rules;
    
    protected $builder_configuration;
    
    protected static $current_position = 0;
    
    public function __construct($name, $label = null, $id = null, $value = null, array $builder_configuration = array())
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
        $this->value = $value;
        $this->rules = array();
        $this->builder_configuration = $builder_configuration;
        
        $this->position = self::$current_position;
        
        self::$current_position++;
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
    }
    
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
    
    public function getRulesSerialized()
    {
        $rules = $this->getRules();
        $array = array();
        foreach($rules as $name => $rule) {
            $array[$name] = is_array($rule->getValue()) ? serialize($rule->getValue()) : $rule->getValue();
        }
        
        return serialize($array);
    }
    
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
    
    
    public function hasRules()
    {
        return 0 != count($this->getRules());
    }
    
    
    public function hasRule($name)
    {
        return array_key_exists($name, $this->getRules());
    }
    
    abstract public function getFieldName();
    
    abstract public function getBody();

    public function getRuleBody()
    {
        $name = $this->getName();
        $value = $this->getRulesSerialized();
        
        return "<input type=\"hidden\" name=\"_rules_$name\" value='$value' />";
    }
    
    public function getMetadataBody()
    {
        $name = $this->getName();
        $type = $this->getFieldName();
        
        return "<input type=\"hidden\" name=\"_type_$name\" value=\"$type\" />";
    }
    
    
    public function getBuilderConfiguration()
    {
        return $this->builder_configuration;
    }
    
}