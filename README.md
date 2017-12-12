[![Build Status](https://api.travis-ci.org/xobotyi/dotarray.svg)](https://travis-ci.org/xobotyi/dotarray)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/6711b15fe32c4346ae53b28df29f29af)](https://www.codacy.com/app/xobotyi/dotarray)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6711b15fe32c4346ae53b28df29f29af)](https://www.codacy.com/app/xobotyi/dotarray)
[![PHP 7 ready](http://php7ready.timesplinter.ch/xobotyi/dotarray/badge.svg)](https://packagist.org/packages/xobotyi/dotarray)
[![Latest Stable Version](https://poser.pugx.org/xobotyi/dotarray/v/stable)](https://packagist.org/packages/xobotyi/dotarray)
[![Total Downloads](https://poser.pugx.org/xobotyi/dotarray/downloads)](https://packagist.org/packages/xobotyi/dotarray)
[![License](https://poser.pugx.org/xobotyi/dotarray/license)](https://packagist.org/packages/xobotyi/dotarray)

Haven't you thought, that using `$array['some']['nested']['array']['value']` is to long and hard at least to write? Well, i did. And made this lib which will help you to manage your arrays in dot-notation style.

This lib will help you to do this:
```php
$var = $array['a']['b']['c']['d'] ?? 'default value';
```
a bit shorter:
```php
$var = A::get($array, 'a.b.c.d', 'default value');
```

## Contents
1. [Requirements](#requrements)
2. [Installation](#installation)
3. [Classes and methods](#classes-and-methods)
    * [xobotyi\A](#xobotyi\a)
        * [Getting](#array-getting)
            * [get](#aget) - Get an element.
            * [values](#avalues) - Get all values.
            * [last](#alast) - Get last element(s).
            * [lastKeys](#alastkeys) - Get key(s) of last elements(s).
            * [first](#afirst) - Get first element(s).
            * [firstKeys](#afirstkeys) - Get key(s) of first elements(s).
        * [Iteration](#array-iteration)
            * [walk](#awalk) - Execute a provided function once for each array element
        * [Checking](#array-checking)
            * [every](#aevery) - Test whether all elements in the array pass the test implemented by the provided function.
            * [any](#aany) - Test whether at least one element in the array passes the test implemented by the provided function.
            * [has](#ahas) - Check whether all provided values presented in array.
            * [hasAny](#ahasany) - Test whether at least one provided value presented in array. 
            * [hasKey](#ahashey) - Check whether all provided values presented in array as key.
            * [hasAnyKey](#ahasanykey) - Check whether at least one provided value presented in array as key. 
            * [arrayKeyExists](#aarraykeyexists) - Check whether array has provided key.
            * [isAssoc](#aisassoc) - Check whether array is associative, e.g. has string keys.
            * [isSequential](#aissequential) - Check whether array is sequential, e.g. has only int keys placed in ascending order.
        * [Modification](#array-modification)
            * [set](#aset) - Set value(s) with provided keys(s).
            * [append](#aappend) - Add element(s) to the end of array.
            * [prepend](#aprepend) - Add element(s) to the beginning of array.
            * [delete](#adelete) - Delete an element with provided keys(s).
            * [chunk](#achunk) - Split array into a chunks of provided size.
            * [flip](#aflip) - Swap keys and values.
        * [Interaction](#arrays-interaction)
            * [diff](#adiff) - Compute right diff of provided arrays.
            * [symdiff](#asymdiff) - Compute symmetric diff of provided arrays.
            * [diffAssoc](#adiffassoc) - Compute intersection of provided arrays with additional index check.
            * [intersect](#aintersect) - Compute intersection of provided arrays.
            * [intersectAssoc](#aintersectassoc) - Compute intersection of provided arrays with additional index check.
        * [Others](#array-others)
            * [glue](#aglue) - Glue array with provided delimiter.
            * [splitPath](#asplitpath) - Split provided string into an array representing nested keys.

## Requrements
- [PHP](//php.net/) 7.1+

## Installation
#### composer require
`composer require xobotyi/dotarray`
#### composer.json
```json
{
    "require": {
      "xobotyi/dotarray":"^1.0.8"
    }
}
```
After that run `composer update` or `php composer.phar update`, and you will be able to `A::set($arrays, 'for.some.dotted.magic')`

## Classes and methods
### xobotyi\A
A is class containing static methods to perform actions on common arrays and ArrayObjects. Someone will think that A is bad or inconvenient name for class, but i think that it's handy to type `A::` without releasing Shift button =)


#### Array getting
##### `A::get(array $array [, ?string $path = null [, $default = null]])`
_**Description:**_ Returns $array's value placed on the $path or $default value if provided $path doesn't exists.
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::values(array $array [, bool $flatten = false])`
_**Description:**_ Returns all the values from the $array as a sequential array (without it's keys).  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::last(array $array [, int $count = 1])`
_**Description:**_ Returns last $count element(s) value(s) from the $array.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::lastKeys(array $array [, int $count = 1])`
_**Description:**_ Returns last $count element(s) key(s) from the $array.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::first(array $array [, int $count = 1])`
_**Description:**_ Returns first $count element(s) value(s) from the $array.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::firstKeys(array $array [, int $count = 1])`
_**Description:**_ Returns first $count element(s) keys from the $array.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

#### Array iteration
##### `A::walk(array $array, callable $callback [, bool $recursive = false])`
_**Description:**_ Applies $callback to each element of the $array.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

#### Array checking
##### `A::every(array $array, callable $callback)`
_**Description:**_ Applies $callback to each $array's element and returns true if EVERY call returned TRUE.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::any(array $array, callable $callback)`
_**Description:**_ Applies $callback to each $array's element and returns true if ANY call returned TRUE.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::has(array $array, ...$values)`
_**Description:**_ Tests whether $array contains ALL of provided ...$values.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::hasAny(array $array, ...$values)`
_**Description:**_ Tests whether $array contains ANY of provided ...$values.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::hasKey(array $array, string ...$paths)`
_**Description:**_ Tests whether $array has ALL of provided ...paths.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::hasAnyKey(array $array, string ...$paths)`
_**Description:**_ Tests whether $array has ANY of provided ...paths.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::arrayKeyExists(array &$array, string $key)`
_**Description:**_ The faster analog to \array_key_exists()  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::isAssoc(array $array)`
_**Description:**_ Tests whether $array is an associative array.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::isSequential(array $array)`
_**Description:**_ Tests whether $array is a sequential (`[1,2,3,4,...]`) array.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

#### Array modification
##### `A::set(array $array, string|array $path [, $value])`
_**Description:**_ Sets the $value on the $path.  
If $path parameter is an array - it's keys will be used as paths and vales as values  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::append(array $array, ...$values)`
_**Description:**_ Adds passed ...$values to the end of $array  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::prepend(array $array, ...$values)`
_**Description:**_ Adds passed ...$values to the beginning of $array  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::delete(array $array, string ...$paths)`
_**Description:**_ Deletes $array's items placed on the provided ...$paths  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::chunk(array $array, int $chunkSize [, bool $preserveKeys = false])`
_**Description:**_ Chunks an array into arrays with $chunkSize elements. The last chunk may contain less than $chunkSize elements.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::flip()`
_**Description:**_ Returns an array in flip order, i.e. keys from array become values and values from array become keys.  
If a value has several occurrences, the latest key will be used as its value, and all others will be lost.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

#### Arrays interaction
##### `A::diff(array $array, array ...$arrays [, bool $preserveKeys])`
_**Description:**_ Compares $array against ...$arrays and returns the values in $array that are not present in any of the other ...$arrays.  
If $preserveKeys set to TRUE values keys will be preserved.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::symdiff()`
_**Description:**_  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::diffAssoc(array $array, array ...$arrays)`
_**Description:**_ Acts like A::diff() but the array keys are also used in the comparison.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::intersect(array $array, array ...$arrays [, bool $preserveKeys])`
_**Description:**_  Compares $array against ...$arrays and returns all the values of $array that are present in all ...$arrays.
If $preserveKeys set to TRUE values keys will be preserved.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::intersectAssoc(array $array, array ...$arrays)`
_**Description:**_ Acts like A::intersect() but the array keys are also used in the comparison.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

#### Array Others
##### `A::splitPath(string $path)`
_**Description:**_  Splits given string to it's segments according to dot notation.
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_

##### `A::glue(array $array, string $glue = '')`
_**Description:**_ Glues $array items into a string, with $glue as delimiter.  
_**Parameters**_  
_**Return Values**_  
_**Errors/Exceptions**_  
_**Examples**_