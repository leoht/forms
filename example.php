<?php
require_once 'src/autoload.php';

use Forms\Builder;

$builder = new Builder;

$builder->configure(array('use_ajax' => true));

$builder->addField('text', 'username', "Your username (required) : <br />")
            ->addRules(array('not_empty' => true));

$builder->addField('email', 'email', 'Your email (required) : <br />');
$builder->addField('email', 'email_confirm', 'Confirm the email : <br />');

$builder->addField('textarea', 'bio', 'Short presentation : <br />');

$builder->addField('checkbox', 'tos', "I agree with the terms of service")
            ->addRules(array('not_empty' => true));

$builder->addSubmit('Submit', 'process.php');


?>
<html>
    <body>
        <h1>Form example</h1>
        <?php echo $builder->getForm()->getBody(); ?>
    </body>
</html>
