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
            'select'    => $namespace . "SelectField",
            'checkbox'  => $namespace . "CheckboxField",
            'date'      => $namespace . "DateField",
            'submit'    => $namespace . "SubmitField",
        );
    }
}
