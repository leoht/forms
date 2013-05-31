#Rules

You can use several validation rules to check the values the user give are correct regarding your application/website needings.
Here's a list of the available rules you can use.

##Not empty

This rule check that a value has been given for the field. Note that a checkbox field is considered as empty if not checked.
```php
$builder->addField('text', 'username', 'Username (required) : ')
            ->addRules(array('not_empty' => true));

// using Rule object
$builder->addField('text', 'username', 'Username (required) : ')
            ->addRule(new Forms\Validation\Rule\NotEmptyRule(true));
```

Note : by default, the builder will create an HTML 5 attribute "required" on the field, which automatically blocks the form submission if the field is empty. If you don't want
the required attribute to be set on the field, you can disable this by configuring the builder :
```php
$builder->configure(array('html5_required' => false));
```

##Max value

Checks that a numeric value is lower than a certain value.
```php
$builder->addField('text', 'age', 'Your age : ')
            ->addRules(array('max' => '120'));

// using Rule object
$builder->addField('text', 'age', 'Your age : ')
            ->addRule(new Forms\Validation\Rule\MaxValueRule(120));
```

##Min value

Checks that a numeric value is greater than a certain value.
```php
$builder->addField('text', 'age', 'Your age : ')
            ->addRules(array('min' => '7'));

// using Rule object
$builder->addField('text', 'age', 'Your age : ')
            ->addRule(new Forms\Validation\Rule\MinValueRule(120));
```

##Between

If the value must be between a minimum and a maximum, you can use the 'between' rule :
```php
$builder->addField('text', 'age', 'Your age : ')
            ->addRules(array('between' => array(7, 120)));

// using Rule object
$builder->addField('text', 'age', 'Your age : ')
            ->addRule(new Forms\Validation\Rule\Between(array(7, 120)));
```

##Max length

Checks if the value's length does not exceed a certain value.
```php
$builder->addField('text', 'phone', 'Your phone number : ')
            ->addRules(array('maxlength' => '14'));

// using Rule object
$builder->addField('text', 'phone', 'Your phone number : ')
            ->addRule(new Forms\Validation\Rule\MaxLengthRule(14));
```

##Min length

Checks if the value's length is greater than a certain value.
```php
$builder->addField('text', 'phone', 'Your phone number : ')
            ->addRules(array('minlength' => '10'));

// using Rule object
$builder->addField('text', 'phone', 'Your phone number : ')
            ->addRule(new Forms\Validation\Rule\MinLengthRule(14));
```

##Number rule

Checks if the value is a numeric value
```php
$builder->addField('text', 'phone', 'Your phone number : ')
            ->addRules(array('number' => true));

// using Rule object
$builder->addField('text', 'phone', 'Your phone number : ')
            ->addRule(new Forms\Validation\Rule\NumberRule(true));
```

##Equals rule

Checks if the value is exactly the same that a certain value.
```php
$builder->addField('text', 'fun', 'Please type "Cat" : ')
            ->addRules(array('equals' => 'Cat'));

// using Rule object
$builder->addField('text', 'fun', 'Please type "Cat" : ')
            ->addRule(new Forms\Validation\Rule\EqualsRule("Cat"));
```

Since this rule can be used for captchas, quizes or anything like this, the rule value is stored in a hidden field but hashed with the sha1 algorithm to prevent
users or bots to read it in the page source code.

##In rule

Checks if the value is in a list of values
```php
$builder->addField('text', 'food', 'Do you prefer : ')
            ->addRules(array('in' => array('Apples', 'Bananas', 'Oranges')));

// using Rule object
$builder->addField('text', 'food', 'Do you prefer : ')
            ->addRule(new Forms\Validation\Rule\BetweenRule(array(
                  'Apples',
                  'Bananas',
                  'Oranges'
            )));
```

##Regexp rule

Checks if the value match with a regular expression
```php
$builder->addField('text', 'food', 'Do you prefer : ')
            ->addRules(array('regexp' => '(Apples)|(Bananas)|(Oranges)'));

// using Rule object
$builder->addField('text', 'food', 'Do you prefer : ')
            ->addRule(new Forms\Validation\Rule\RegexpRule('(Apples)|(Bananas)|(Oranges)'))
```