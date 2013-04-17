<?php
namespace Forms\Validation\Rule;

use Forms\Validation\Rule\Rule;
use Forms\Field\Field;

/**
 * EqualsRule :
 * Field value must equals a certain value.
 * Since this rule can be used for captchas or quizzes (or anything else like this),
 * the value stored in the hidden input is hashed by sha1 algorithm, avoiding user or bots
 * reading it in the page source code.
 */
class EqualsRule extends Rule
{
    public function getName()
    {
        return 'equals';
    }
    
    public function isValueValid($value)
    {
        return is_numeric($value) || is_string($value);
    }
    
    public function getExpectedValueType()
    {
        return 'string';
    }
    
    public function isFieldValid(Field $field)
    {
        return $this->value == sha1($field->getValue());
    }
    
    public function getValue()
    {
        return sha1($this->value);
    }
    
}