<?php
namespace Forms\Builder;

use Forms\Field\Field;
use Forms\Builder\FormBuilder;
use Forms\Validation\Validator;

class Form
{
    protected $builder;
    
    protected $fields;
    
    protected $method;
    
    protected $action;
    
    protected $raw_data;
    
    public static function fromRequest(FormBuilder $builder)
    {
        $form = new self($builder);
        $form->raw_data = $_POST;
        
        $form->buildFromRaw();
        
        return $form;
    }
    
    
    public function buildFromRaw()
    {
        $raw = $this->raw_data;
        $types = $this->getBuilder()->getFieldTypes();
        
        foreach($raw as $key => $value) {
            
            $matches = array();
            
            
            if (!preg_match('#^_rules_(.+)$#is', $key) && !preg_match('#^_type_(.+)$#is', $key)) {   // it's a field value
                $name = $key;
                if ($this->hasField($name)) {
                    $this->getField($name)->setName($name);
                    $this->getField($name)->setValue($value);
                } else {
                    $type = $types[$raw["_type_$name"]];
                    $field = new $type($name);
                    $field->setValue($value);
                    $this->addField($field);
                }
            } 
            
            else if (preg_match('#^_rules_(.+)$#is', $key, $matches)) {    // it's a rule
                
                $name = $matches[1];
                
                if ($this->hasField($name)) {
                    $this->getField($name)->unserializeRules($value);
                } else {
                    $type = $types[$raw["_type_$name"]];
                    $field = new $type($name);
                    $field->unserializeRules($value);
                    $this->addField($field);
                }
            }
        }
        
        return $this;
    }
    
    
    public function isValid()
    {
        $results = Validator::getValidation($this);
        
        
        foreach ($results as $field => $result) {
            if (!$result['valid']) {
                return false;
            }
        }
        
        return true;
    }
    
    
    
    public function getBody()
    {
        $fields = $this->getFields();
        $method = $this->method;
        $action = $this->action;
        
        $body = "<form action=\"$action\" method=\"$method\" enctype=\"multipart/form-data\" > \r\n";

        foreach($fields as $field) {
            $body .= "<p> \r\n";
            
            $body .= $field->getBody() . "\r\n";
            if ($field->getFieldName() != 'submit') {
                $body .= $field->getMetadataBody() . "\r\n";
            }
            if ($field->hasRules()) {
                $body .= $field->getRuleBody() . "\r\n";
            }
            $body .= "</p> \r\n";
        }
        
        $body .= "</form> \r\n";
        
        return $body;
    }
    
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
        $this->fields = array();
    }
    
    public function addField(Field $field)
    {
        $this->fields[$field->getName()] = $field;
    }
    
    public function getFields()
    {
        return $this->fields;
    }
    
    
    
    /**
     * @param string $name
     * @return Field 
     */
    
    public function getField($name)
    {
        return $this->fields[$name];
    }
    
    public function hasField($name)
    {
        return array_key_exists($name, $this->fields);
    }
    
    public function getBuilder()
    {
        return $this->builder;
    }
    
    public function setMethod($method)
    {
        $this->method = $method;
    }
    
    public function setAction($action)
    {
        $this->action = $action;
    }
}