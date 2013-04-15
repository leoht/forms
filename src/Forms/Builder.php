<?php
namespace Forms;

use Forms\Builder\FormBuilder;

class Builder extends FormBuilder
{
    public function getFieldTypes()
    {
        $namespace = "Forms\\Field\\";
        
        return array(
            'text'      => $namespace . "TextField",
            'textarea'  => $namespace . "TextareaField",
            'password'  => $namespace . "PasswordField",
            'select'    => $namespace . "SelectField",
            'checkbox'  => $namespace . "CheckboxField",
            'email'     => $namespace . "EmailField",
            'date'      => $namespace . "DateField",
            'submit'    => $namespace . "SubmitField",
        );
    }
}
