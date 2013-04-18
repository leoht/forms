#Field types

You can use various field types to build your form, here is the complete list of all the available types and their documentation.
You can also create your own field type.

##Text

This a simple text field, on a single line
```php
$builder->addField('text', 'username', 'Your username : ');
```

##Textarea

A textarea field, as in HTML
```php
$builder->addField('textarea', 'message', 'Your message : ');
```

##Password

A password field
```php
$builder->addField('password', 'userpass', 'Your password : ');
```

##Email

Like a text field, except that the field will be valid only if the user enters a valid email address
(actually the regexp rule is automatically added to the field, with the regular expression of an email address).
```php
$builder->addField('email', 'email', 'Your email address : ');
```

##File

A field to upload some file
```php
$builder->addField('file', 'upload', 'Your upload : ');
```

##Checkbox

A checkbox
```php
$builder->addField('checkbox', 'conditions', 'I agree with terms of service');
```

##Select

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

##Choice

A choice field is like a select field, but a radio button will be created for each choice the user can make. Only one choice is possible.
```php
$builder->addField('choice', 'gender', 'Are you : ')
            ->addChoice('m', 'a male')
            ->addChoice('f', 'a female')
            ->addChoice('a', 'an alien');
```

##Object

An object field is actually more a "super field" that crates one text field for each attribute of the given object.
```php
$my_object = new SomeClass();
$my_object->foo = "Bar"
$builder->addField('object', 'object', null, null, $my_object);
```
Note that the attributes you want in the form must have the public visibility. If you don't want some attribute to be
in the form, you can set them private or use the `ignoreAttribute($attribute)` method on the object field.

Since every attribute will have it's own field, you can set rules or custom label for each of them
```php
$my_object = new SomeClass();
$my_object->foo = 'Bar';
$builder->addField('object', 'object', null, null, $my_object)
            ->setAttributeLabel('foo', 'Foo : ')
            ->setAttributeRules('foo', array('equals' => 'Bar'));
```


##Quiz

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

##Create your own field type

Creating your own field type is really easy. Your type can be any PHP class but it must extends <b>Forms\Field\Field</b> or any other field type that extends it.
Since your class extends it, you must redeclare the two abstract methods `getFieldName()` and `getBody()`.

Let's take a really simple example : suppose you want to create a specific field to store an age. So your field must accept only numbers between 13 (supposing your website
only accepts children older than 13) and let's say 122 (!). You can of course do this with rules (and we're going to use rules, indeed) on a simple text field, but let's create
this custom field type for the example :

```php
use Forms\Field\TextField

class MyAgeField extends TextField {
    
    public function __construct($name, $label = null, $id = null, $value = null, $builder_configuration = array())
    {
        parent::__construct($name, $label, $id, $value, $builder_configuration);
        $this->addRules(array('number' => true, 'between' => array(13, 122)); // here we go, adding the rules we told before to match a valid age
    }

    // we don't have to redeclare the getBody() method,
    // because our class extends TextField, which already redeclare this method.
    // And since our field will only be a simple text field with rules added to it, we don't have to worry about it at all.

    // but you must redeclare getFieldName()
    public function getFieldName()
    {
        return 'age';
    }
}
```

Now you have to tell the builder that your field exist and can be used into your form, you can do that with the builder's `addFieldType($type, $class)` method.
```php
$builder->addFieldType('age', 'MyAgeField');
```

And that's it !