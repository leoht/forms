Forms
=====

Build and manage forms in PHP with automatic validation rules

```php
<?php
use Forms\Builder;

$builder = new Builder();
  
$builder->addField('text', 'username', 'Your username : ');
$builder->addField('text', 'userpass', 'Your userpass : ');
$builder->addSubmit('Go !', 'process.php');

?>
```
