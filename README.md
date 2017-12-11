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
            * [has](#ahas) - Test whether at least one provided value presented in array. 
            * [hasAny](#ahasany) - Check whether all provided values presented in array.
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

#### `A::get()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::values()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::last()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::lastKeys()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::first()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::firstKeys()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### Array iteration

#### `A::walk()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### Array checking

#### `A::every()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::any()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::has()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::hasAny()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::hasKey()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::hasAnyKey()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::arrayKeyExists()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::isAssoc()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::isSequential()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### Array modification

#### `A::set()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::append()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::prepend()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::delete()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::chunk()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::flip()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### Arrays interaction

#### `A::diff()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::symdiff()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::diffAssoc()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::intersect()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::intersectAssoc()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### Array Others

#### `A::splitPath()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### `A::glue()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*