Doctrine Simple Array Types
===========================

A [Doctrine field type](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/types.html) for simple arrays of integers and strings.

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
```

Or, if you're using the Symfony, set types in your Doctrine configuration file (eg: doctrine.yml):

```yaml
doctrine:
    dbal:
        types:
            simple_string_array: 'DavidKmenta\DoctrineSimpleArrayTypes\SimpleStringArrayType'
            simple_integer_array: 'DavidKmenta\DoctrineSimpleArrayTypes\SimpleIntegerArrayType'
```

Then, in your entities, you may annotate properties by setting the `@Column` type to `simple_string_array` or `simple_integer_array`.
