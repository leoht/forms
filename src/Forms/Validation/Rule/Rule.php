<?php
namespace Forms\Validation\Rule;

use Forms\Field\Field;

/**
 * @abstract 
 */
abstract class Rule
{
    /**
     * @var mixed 
     */
    protected $value;
    
    /**
     * Set the value of the rule.
     * 
     * @param mixed $value
     * @throws \UnexpectedValueException if the given value is not valid for the rule.
     */
    public function setValue($value)
    {
        if (!$this->isValueValid($value)) {
            throw new \UnexpectedValueException(sprintf("Unexpected value for rule '%s' (%s expected).", $this->getName(), $this->getExpectedValueType()));
        }
        $this->value = $value;
    }
    
    /**
     * Get the rule value.
     * 
     * @return mixed 
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * Get the name of the rule. 
     */
    abstract public function getName();
    
    /**
     * Get the expected type for the rule value. 
     */
    abstract public function getExpectedValueType();
    
    /**
     * Test if the rule value is valid. 
     */
    abstract public function isValueValid($value);
    
    /**
     * Applies the rule on a field and tests if its value is valid.
     */
    abstract public function isFieldValid(Field $field);
}