<?php
namespace Forms;

use Forms\Builder\FormBuilder;

class Builder extends FormBuilder
{
    public function getFieldTypes()
    {
        $namespace = "Forms\\Field\\";
        
        return array_merge( array(
                    'text' => $namespace . "TextField",
                    'textarea' => $namespace . "TextareaField",
                    'password' => $namespace . "PasswordField",
                    'select' => $namespace . "SelectField",
                    'checkbox' => $namespace . "CheckboxField",
                    'choice' => $namespace . "ChoiceField",
                    'email' => $namespace . "EmailField",
                    'file' => $namespace . "FileField",
                    'quiz' => $namespace . "QuizField",
                    'captcha' => $namespace . "SimpleCaptchaField",
                    'object' => $namespace . "ObjectField",
                    'submit' => $namespace . "SubmitField",
                ), $this->getExtraFieldTypes());
    }
}
