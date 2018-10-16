<?php declare(strict_types=1);

namespace DavidKmenta\DoctrineSimpleArrayTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\SimpleArrayType;
use Doctrine\ORM\UnexpectedResultException;

class SimpleIntegerArrayType extends SimpleArrayType
{
    public const SIMPLE_INTEGER_ARRAY = 'simple_integer_array';

    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        if ($value === '') {
            return [];
        }

        $convertedValue = array_map('intval', parent::convertToPHPValue($value, $platform));

        if (parent::convertToDatabaseValue($convertedValue, $platform) !== $value) {
            throw new UnexpectedResultException(
                sprintf('Value "%s" cannot be converted into array of integers!', $value)
            );
        }

        return $convertedValue;
    }

    public function getName(): string
    {
        return self::SIMPLE_INTEGER_ARRAY;
    }
}
