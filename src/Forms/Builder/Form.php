<?php
namespace Forms\Builder;

use Forms\Field\Field;
use Forms\Builder\FormBuilder;
use Forms\Validation\Validator;

/**
 * A form.
 * 
 * @author Leo Hetsch 
 */
class Form
{
    /**
     * @var FormBuilder 
     */
    protected $builder;
    
    /**
     * @var array 
     */
    protected $fields;
    
    /**
     * @var string 
     */
    protected $method;
    
    /**
     * @var string 
     */
    protected $action;
    
    /**
     * @var array 
     */
    protected $raw_data;
    
    /**
     * Load the form from an HTTP request.
     * 
     * @static
     * @return Form
     */
    public static function fromRequest(FormBuilder $builder)
    {
        $form = new self($builder);
        $form->raw_data = $_POST;
        
        $form->buildFromRaw();
        
        return $form;
    }
    
    /**
     * Build the form from raw POST data.
     * 
     * @return \Forms\Builder\Form 
     */
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
            
            else if (preg_match('#^_type_(.+)$#is', $key, $matches)) { // metadata
                $name = $matches[1];
                
                if (!$this->hasField($name)) {
                    $type = $types[$raw["_type_$name"]];
                    $field = new $type($name);
                    $this->addField($field);
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Test if the form is valid using rules.
     * 
     * @return boolean 
     */
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
    
    
    
    
    /**
     * Get the form body as HTML.
     * 
     * @return string 
     */
    public function getBody()
    {
        $fields = $this->getFields();
        $method = $this->method;
        $action = $this->action;
        $id = uniqid();
        
        $config = $this->getBuilder()->getConfiguration();
        
        $body = "<form action=\"$action\" id=\"form_$id\" method=\"$method\" enctype=\"multipart/form-data\" > \r\n
                    <p id=\"msg_form_$id\" >
                    </p>";
        
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
        
        if ($config['use_ajax']) {
            $body .= "<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js\"></script>\r\n
                      <script type=\"text/javascript\" >
                            $(function(){
                                $('#form_{$id}').submit(function(e){
                                    e.preventDefault();
                                    var failed = false;
                                
                                    $.ajax({
                                        url : '$action',
                                        type : '$method',
                                        dataType : 'json',
                                        data : $(this).serialize(),
                                        success : function(data){
                                            $.each(data, function(field,values){
                                                if (values['valid'] == false){
                                                    failed = true;
                                                }
                                            });
                                
                                            if (failed) { $('#form_{$id} #msg_form_{$id}').html('{$config['ajax_error_msg']}'); }
                                        }
                                    });
                                
                                });
                            });
                        </script>";
        }
        
        return $body;
    }
    
    
    
    
    /**
     * Constructor
     * @param FormBuilder $builder 
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
        $this->fields = array();
    }
    
    /**
     * Add a field
     * @param Field $field 
     */
    public function addField(Field $field)
    {
        $this->fields[$field->getName()] = $field;
    }
    
    /**
     * Get the form fields
     * @return array 
     */
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
    
    /**
     * Test if a form has a field
     * @param string $name
     * @return boolean 
     */
    public function hasField($name)
    {
        return array_key_exists($name, $this->fields);
    }
    
    /**
     * Get the form builder
     * @return FormBuilder 
     */
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