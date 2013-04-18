#Field types

You can use various field types to build your form, here is the complete list of all the available types and their documentation.
You can also create your own field type.

##text

This a simple text field, on a single line
```php
$builder->addField('text', 'username', 'Your username : ');
```

##textarea

A textarea field, as in HTML
```php
$builder->addField('textarea', 'message', 'Your message : ');
```

##password

A password field
```php
$builder->addField('password', 'userpass', 'Your password : ');
```

##email

Like a text field, except that the field will be valid only if the user enters a valid email address
(actually the regexp rule is automatically added to the field, with the regular expression of an email address).
```php
$builder->addField('email', 'email', 'Your email address : ');
```

##file

A field to upload some file
```php
$builder->addField('file', 'upload', 'Your upload : ');
```

##checkbox

A checkbox
```php
$builder->addField('checkbox', 'conditions', 'I agree with terms of service');
```

##select

A select list with options. Use the `addOption($value, $label, $default)` on the field object to add an option.
The `$default` parameter is optional and has its default value set to false. If set to true, the option will be selected by default.
```php
$builder->addField('select', 'food', 'Do you prefer : ')
            ->addOption('bananas', 'Bananas')
            ->addOption('apples', 'Apples', true)
            ->addOption('oranges', 'Oranges');
```
You can also allow multiple selection, using the `setMultiple()` method
```php
$builder->addField('select', 'food', 'Do you prefer : ')
            ->addOption('bananas', 'Bananas')
            ->addOption('apples', 'Apples', true)
            ->addOption('oranges', 'Oranges')
            ->setMultiple();
```

##choice

A choice field is like a select field, but a radio button will be created for each choice the user can make. Only one choice is possible.
```php
$builder->addField('choice', 'gender', 'Are you : ')
            ->addChoice('m', 'a male')
            ->addChoice('f', 'a female')
            ->addChoice('a', 'an alien');
```

##quiz

With the quiz field you can propose a question randomly choosen in a list of questions you created, and the field is valid only if the user gives the right answer.
```php
$builder->addField('quiz', 'quiz')
            ->addQuestion('Capital of England ?', 'London')
            ->addQuestion('Color of the sky ?', 'Blue');
```
Note that since the field label will automatically take the value of the choosen question, you don't have to provide a label value.
You can also allow multiple answers possible for the same question, separating each one by a pipe (|) :
```php
$builder->addField('quiz', 'quiz')
            ->addQuestion('Capital of England ?', 'London')
            ->addQuestion('Color of the sky ?', 'Blue|Cyan');
```

##Simple math captcha

A very simple mathematical captcha, this field is actually a good example of how you can extend the quiz field type.
The user must give the result of a simple operation, if the result is wrong, the field will not be valid (since it uses the equals rule). The `setQuestion($question, $operation)` allow you to set the pattern
of the question and the math operation.
```php
$builder->addField('simple_captcha', 'captcha')
            ->setQuestion('How much are % and % ?', '+');
```
Note that the two '%' will be replaced by the randomly choosen numbers. The argument `$operation` can be set to '+','-','*' or '/'.