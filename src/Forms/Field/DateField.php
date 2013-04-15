<?php
namespace Forms\Field;

use Forms\Field\Field;

class DateField extends Field
{
    
    public function getBody()
    {
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue();
        $label  = $this->getLabel();
        
        $options_day = '';
        for ($i = 1 ; $i <= 31 ; $i++) {
            $options_day .= "<option value=\"$i\" >$i</option>";
        }
        $options_month = '';
        for ($i = 1 ; $i <= 12 ; $i++) {
            $options_month .= "<option value=\"$i\" >$i</option>";
        }
        $options_year= '';
        for ($i = 1900 ; $i <= date('Y') ; $i++) {
            $options_year .= "<option value=\"$i\" >$i</option>";
        }
        
        return "<label for=\"$id\" >$label</label>
                <select name=\"{$name}_day\" id=\"$id\" >
                    $options_day
                </select>
                <select name=\"{$name}_month\" id=\"$id\" >
                    $options_month
                </select>
                <select name=\"{$name}_year\" id=\"$id\" >
                    $options_year
                </select>";
    }
    

    public function getFieldName()
    {
        return 'date';
    }
}