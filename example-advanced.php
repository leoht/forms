<?php
require_once 'src/autoload.php';

use Forms\Builder;

$builder = new Builder();

$builder->configure(array('use_ajax' => true));

$builder->addField('quiz', 'quiz')
			->addQuestion('What is the capital of USA ?', 'Washington')
			->addQuestion('What is the color of apples ?', 'Red|Green|Yellow');

$builder->addField('captcha', 'captcha')
			->setQuestion('Please do the math : % x % ?', '*');

$builder->addSubmit('Submit', 'process.php');


?>
<html>
    <body>
        <h1>Form example</h1>
        <?php echo $builder->getForm()->getBody(); ?>
    </body>
</html>
