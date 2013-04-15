<?php
namespace Forms\Builder;

use Forms\Builder\Form;

class FormBuilder
{
    
    /**
     * @var Form 
     */
    protected $form;
    
    
    /**
     * Get the different field types.
     * @return array 
     */
    public function getFieldTypes()
    {
        return array();
    }
    
    
    /**
     * Constructor
     * @param Form $form
     */
    public function __construct($form = null)
    {
        if (!$form) {
            $form = new Form($this);
        }
        
        $this->form = $form;
    }
    
    
    public function loadFromRequest()
    {
        $this->form = Form::fromRequest($this);
    }
    
    
    public function getForm()
    {
        return $this->form;
    }
    
    /**
     * Add a field to the form.
     * 
     * @param string $type
     * @param string $name
     * @param string $id
     * @param string $value
     * @return Forms\Field\Field
     * @throws \LogicException if the type or the associated class doesn't exist.
     */
    public function addField($type, $name, $label = null, $id = null, $value = null)
    {
        if ($this->getForm()->hasField($name)) {
            throw new \LogicException(sprintf("A form cannot have two fields with the same name."));
        }
        
        $types = $this->getFieldTypes();
        
        foreach($types as $fieldType => $class) {
            
            if ($type == $fieldType) {
                
                if (!class_exists($class)) {
                    throw new \LogicException(sprintf("Class '%s' not found for field type '%s'.", $class, $fieldType));
                }
                
                $this->form->addField(new $class($name, $label, $id, $value));
                
                return $this->form->getField($name);
            }
        }
        
        throw new \LogicException(sprintf("There is no field type called '%s'.", $type));
    }
    
    
    public function addSubmit($label, $action, $method = 'POST')
    {
        $types = $this->getFieldTypes();
        
        $class = $types['submit'];
        
        $this->form->addField(new $class($label));
        
        $this->form->setAction($action);
        $this->form->setMethod($method);
        
        return $this->form;
    }
    
    /**
     * Guess the field type to instanciate
     * 
     * @param mixed $value
     * @return string the class to instanciate 
     */
    public function guessFieldType($name, $value)
    {
        $types = $this->getFieldTypes();
        
        // custom field type guessing
        foreach($types as $type) {
            if (method_exists($type, 'addGuessing')) {
                $fieldObj = new $type($name);
                if ($fieldObj->addGuessing($name, $value)) {
                    return $type;
                }
            }
        }
        
        if (is_string($value)) {
            return (strlen($value) <= 255) ? $types['text'] : $types['textarea'];
        }
        if (is_numeric($value)) {
            return $types['text'];
        }
        if (is_bool($value)) {
            return $types['checkbox'];
        }
    }
}
