Doctrine Simple Array Types
===========================

A [Doctrine field type](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/types.html) for simple arrays of integers, floats and strings.

## Description

These types mainly solve two common problems:

* _simple_string_array_ solves the problem with strings containing a comma symbol. Such strings cannot be persisted in the _simple_array_ type provided by the Doctrine. 
* _simple_integer_array_ and _simple_float_array_ extends the _simple_array_ type from the Doctrine. These types solve the problem when [a persisted integer or float is returned from the database as a string](https://www.doctrine-project.org/projects/doctrine-dbal/en/2.8/reference/types.html#simple-array). 


## Installation

Run the following command:

```bash
composer require davidkmenta/doctrine-simple-array-types
```

## Examples

To configure Doctrine to use this set of types, you'll need to set up the following in your bootstrap:

``` php
<?php

\Doctrine\DBAL\Types\Type::addType('simple_string_array', 'DavidKmenta\DoctrineSimpleArrayTypes\SimpleStringArrayType');
$entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('simple_string_array', 'simple_string_array');

\Doctrine\DBAL\Types\Type::addType('simple_integer_array', 'DavidKmenta\DoctrineSimpleArrayTypes\SimpleIntegerArrayType');
$entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('simple_integer_array', 'simple_integer_array');

\Doctrine\DBAL\Types\Type::addType('simple_float_array', 'DavidKmenta\DoctrineSimpleArrayTypes\SimpleFloatArrayType');
$entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('simple_float_array', 'simple_float_array');
```

Or, if you're using the Symfony, set types in your Doctrine configuration file (eg: doctrine.yml):

```yaml
doctrine:
    dbal:
        types:
            simple_string_array: 'DavidKmenta\DoctrineSimpleArrayTypes\SimpleStringArrayType'
            simple_integer_array: 'DavidKmenta\DoctrineSimpleArrayTypes\SimpleIntegerArrayType'
            simple_float_array: 'DavidKmenta\DoctrineSimpleArrayTypes\SimpleFloatArrayType'
```

Then, in your entities, you may annotate properties by setting the `@Column` type to `simple_string_array`, `simple_integer_array` or `simple_float_array`.
