<?php
namespace Forms\Field;

use Forms\Field\QuizField;

/**
 * Simple math captcha 
 */
class SimpleCaptchaField extends QuizField
{
    
    /*
     * Randomly generate two numbers
     */
    public function generateNumbers()
    {
        $a = mt_rand(0,9);
        $b = mt_rand(0,9);
        
        return array('a' => $a, 'b' => $b);
    }
    
    /**
     * Set the question pattern
     * Every '%' in the pattern will be replaced in the field label by one of the two captcha operands
     * 
     * @param string $question
     * @param string $operation The operation to answer, it can be '+','-','*' or '/'
     * 
     * @return \Forms\Field\SimpleCaptchaField 
     */
    public function setQuestion($question, $operation = '+')
    {
        $numbers = $this->generateNumbers();
        $a = $numbers['a'];
        $b = $numbers['b'];
        $question = str_replace("%", "%s", $question);
        $question = sprintf($question, $a, $b);
        
        switch($operation) {
            case '+' :
                $result = $a + $b;
                break;
            case '*' :
                $result = $a * $b;
                break;
            case '-' :
                $result = $a - $b;
                break;
            case '/' :
                $result = $a / $b;
                break;
        }
        
        $this->questions[] = array('question' => $question, 'answer' => $result);
        
        return $this;
    }
    
    /**
     * Overriden method to avoid adding multiple questions.
     * @see Forms\Field\QuizField::addQuestion
     */
    public function addQuestion($question, $answer)
    {
        return $this;
    }

    public function getFieldName()
    {
        return 'captcha';
    }
}