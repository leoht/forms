<?php
namespace Forms\Validation;

use Forms\Builder\Form;
use Forms\Validation\Rule\Rule;

class Validator
{
    public static function getRules()
    {
        $namespace = "Forms\\Validation\\Rule\\";
        
        return array(
            "max"       =>  $namespace . "MaxValueRule",
            "min"       =>  $namespace . "MinValueRule",
            "maxlength" =>  $namespace . "MaxLengthValueRule",
            "minlength" =>  $namespace . "MinLengthValueRule",
            "between"   =>  $namespace . "BetweenRule",
            "not_empty" =>  $namespace . "NotEmptyRule",
            "number"    =>  $namespace . "NumberRule",
            "regexp"    =>  $namespace . "RegexpRule",
            "equals"    =>  $namespace . "EqualsRule",
        );
    }
    
    /**
     * @param string $name
     * @return Forms\Validation\Rule\Rule
     */
    public static function getRule($name)
    {
        $rules = self::getRules();
        
        foreach($rules as $ruleName => $class) {
            if ($name == $ruleName) {
                return new $class();
            }
        }
    }
    
    /**
     * @param string $name
     * @return Boolean 
     */
    public static function hasRule($name)
    {
        return array_key_exists($name, self::getRules());
    }
    
    
    public static function getValidation(Form $form)
    {
        $fields = $form->getFields();
        
        $result = array();
        
        foreach($fields as $name => $field) {
            if ($field->hasRules()) {
                $rules = $field->getRules();
                
                foreach($rules as $name => $rule) {
                    if (self::hasRule($name)) {
                        
                        if (!$rule->isFieldValid($field)) {
                            $result[$field->getName()] = array(
                                'valid' => false,
                                'rules' => $rules
                            );
                            
                            break;
                        } else {
                            $result[$field->getName()] = array(
                                'valid' => true
                            );
                        }
                    }
                }
            }
        }
        
        return $result;
    }
}