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
            * [get](#aget)
            * [values](#avalues)
            * [last](#alast)
            * [lastKeys](#alastkeys)
            * [first](#afirst)
            * [firstKeys](#afirstkeys)
        * [Iteration](#array-iteration)
            * [every](#aevery)
            * [any](#aany)
            * [walk](#awalk)
        * [Checking](#array-checking)
            * [has](#ahas)
            * [hasAny](#ahasany)
            * [hasKey](#ahashey)
            * [hasAnyKey](#ahasanykey)
            * [arrayKeyExists](#aarraykeyexists)
            * [isAssoc](#aisassoc)
            * [isSequential](#aissequential)
        * [Modification](#array-modification)
            * [set](#aset)
            * [append](#aappend)
            * [prepend](#aprepend)
            * [delete](#adelete)
            * [chunk](#achunk)
            * [flip](#aflip)
        * [Interaction](#arrays-interaction)
            * [diff](#adiff)
            * [symdiff](#asymdiff)
            * [diffAssoc](#adiffassoc)
            * [intersect](#aintersect)
            * [intersectAssoc](#aintersectassoc)
        * [Others](#array-others)
            * [glue](#aglue)
            * [splitPath](#asplitpath)

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

#### `A::walk()`
##### *Description*
##### *Parameters*
##### *Return Values*
##### *Errors/Exceptions*
##### *Examples*
##### *Notes*

#### Array checking

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