Ogöudat's core PHP library
==========================

The main goal of Ogöudat's core PHP library is to provide a solid well-tested foundation when working with string manipulation and language processing in PHP.

Please note that this project is in an early stage and the code is not ready for production use yet.

Installation
------------

```
composer require ogoudat/core
```

Strings
-------

Working with Unicode strings in PHP can be difficult and error prone. The `Strang` class is an attempt to hide some of that complexity behind an object-oriented interface.

### Characters

Typically, when working with standard string functions like `strlen`, length means the number of bytes. When using a `Strang` the length is the number of characters.

```php
<?php
use Ogoudat\Core\Strang;

// let us assume that the code is UTF-8 encoded
$name = new Strang('Ogöudat');

echo $name->length() . PHP_EOL; // will print 7
echo $name->byteCount() . PHP_EOL; // will print 8
```

You can get each character as an array of `Character` objects which has its own set of methods.

```php
<?php
use Ogoudat\Core\Strang;

// let us assume that the code is UTF-8 encoded
$strang = new Strang('αβγ');

// Will take each character, make it upper case, and print it along with the
// code point for that character.
foreach ($strang->characters() as $character) {
	$c = $character->toUpperCase();
    echo $c . ': ' . $c->codePoint() . PHP_EOL;
}
```

Coding Style
------------

This project tries to follow the coding style described in [PSR-2](http://www.php-fig.org/psr/psr-2/). Use this section to document things that PSR-2 doesn't cover.

If you would like to use the [PHP Coding Standards Fixer](http://cs.sensiolabs.org/) copy the `.php_cs.dist` configuration file to `.php_cs` and run `php-cs-fixer fix` from the project root directory.

License
-------

This library is licensed under the BSD license. See the `LICENSE.md` file for details.

