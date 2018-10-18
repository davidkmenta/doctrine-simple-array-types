<?php declare(strict_types=1);

namespace DavidKmenta\DoctrineSimpleArrayTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\SimpleArrayType;
use Doctrine\Instantiator\Exception\UnexpectedValueException;
use Doctrine\ORM\UnexpectedResultException;

class SimpleFloatArrayType extends SimpleArrayType
{
    public const SIMPLE_FLOAT_ARRAY = 'simple_float_array';

    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        if ($value === '') {
            return [];
        }

        $convertedValue = array_map('floatval', parent::convertToPHPValue($value, $platform));

        if (parent::convertToDatabaseValue($convertedValue, $platform) !== $value) {
            throw new UnexpectedResultException(
                sprintf('Value "%s" cannot be converted into array of floats!', $value)
            );
        }

        return $convertedValue;
    }

    public function getName(): string
    {
        return self::SIMPLE_FLOAT_ARRAY;
    }
}
