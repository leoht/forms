# Forms

Forms allow you to build forms in PHP and manage their validation requirements.
You can easily add several types of fields to your form and set rules for each of them to control submission by the user

```php
$builder = new Builder();
  
$builder->addField('text', 'username', 'Your username : ');
$builder->addField('password', 'userpass', 'Your userpass : ');

$builder->addSubmit('Go !', 'process.php');
```

## Installation

Download the sources directory (src) and include the autoload.php file into your PHP script, now you're ready to use Forms.
```php
require_once 'src/autoload.php';
```

## Build a form

You can build a form using a Builder object :
```php
use Forms\Builder;

$builder = new Builder();
  
$builder->addField('text', 'username', 'Your username : ');
$builder->addField('password', 'userpass', 'Your userpass : ');

$builder->addSubmit('Go !', 'process.php');
```
the `addField($type, $name, $label, $id, $value)` method expect the following parameters :
- `$type` is the type of the field, such as "text", "textarea", "password", etc. See <b>doc/fields.md</b> for the complete list of available fields types.
- `$name` is the name of the field, which must be unique
- `$label` is the displayed label of the field
- `$id` is the HTML id of the field. If not given, it will have the same value that `$name`
- `$value` is the default value for the field, if there's one

## Display the form

To get the generated HTML for the whole form, use `getForm()` to retrieve the Form object, and use the `getBody()` method on it.
```php
$html = $builder->getForm()->getBody();

echo $html;
```

## Retrieve the form after submitting

To get back your form after submission, you must use the `loadFromRequest()` method on the Builder object.
```php
$builder->loadFromRequest();
```
The form will be automatically populated with the entered values and the rules you set before.

## Add validation rules

Validation rules allow you to control the user input, you can add one or several rules to the same field. If one of the rules is not
respected when the form is submitted, the form is considered as not valid.
```php
$builder->addField('text', 'username', 'Your username : ')
            ->addRules(array(
                    'not_empty' => true
                ));

$builder->addField('text', 'age', 'Your age : ')
            ->addRules(array(
                    'between' => array(12, 112) // if you consider age is valid if it is between 12 and 122 y.o
                ));

$builder->addField('text', 'fruit', 'Which fruit do you prefer ?')
            ->addRules(array(
                    'in' => array('Apple', 'Banana', 'Orange') // only 'Apple', 'Banana' and 'Orange' are valid values
                ));
```

You can also directly use a Rule object (which are all located under namespace Forms\Validation\Rule), like this :

```php
use Forms\Validation\Rule\MaxValueRule;
use Forms\Validation\Rule\NumberRule

// instanciate the builder, etc...

$builder->addField('text', 'age', 'Enter your age: ')
            ->addRule(new NumberRule(true) )
            ->addRule(new MaxValueRule(120) );
```

Validity of the form can be tested after submission using the `isValid()` method on the Form object.
See <b>doc/rules.md</b> for the list of all available rules.

## Add custom configuration

You can configure the builder to change your forms behaviour, using the method `configure($values)` on the builder.
For example, if you want your form to be submitted using AJAX rather than a classic http POST request :
```php
$builder->configure(array(
                        'use_ajax' => true
                    ));
```
