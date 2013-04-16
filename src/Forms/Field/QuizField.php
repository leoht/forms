<?php
namespace Forms\Field;

use Forms\Field\Field;

class QuizField extends Field
{
    protected $questions = array();
    
    public function addQuestion($question, $answer)
    {
        $this->questions[] = array(
                                'question' => $question,
                                'answer' => $answer
                            );
        return $this;
    }
    
    public function getRandomQuestion()
    {
        $i = mt_rand(0, count($this->questions) - 1);
        
        return $this->questions[$i];
    }
    
    public function getBody()
    {
        $question = $this->getRandomQuestion();
        $answer = $question['answer'];
        
        $id     = $this->getId() ? $this->getId() : $this->getName();
        $name   = $this->getName();
        $value  = $this->getValue();
        $label  = $question['question'];
        
        $config = $this->getBuilderConfiguration();
        $required = $this->hasRule('not_empty') && $config['html5_required'] ? 'required' : '';
        
        // if there are pipes (|) in the answer, it means there are multiple possibles answers
        // so we use the "in" rule instead of the "equals" rule.
        if (strpos($answer, '|') !== false) {
            $answers = explode('|', $answer);
            $this->addRules(array('in' => $answers));
        } else {
            $this->addRules(array('equals' => $answer));
        }
        ;
        
        return "<label for=\"$id\" >$label</label> <input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" $required />";
    }
    
    

    public function getFieldName()
    {
        return 'quiz';
    }
}