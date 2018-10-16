<?php declare(strict_types=1);

namespace DavidKmenta\DoctrineSimpleArrayTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class SimpleStringArrayType extends Type
{
    public const SIMPLE_STRING_ARRAY = 'simple_string_array';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!$value) {
            return null;
        }

        $value = array_map(
            function ($value) {
                return sprintf('"%s"', addslashes($value));
            },
            $value
        );

        return implode(',', $value);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        if ($value === null) {
            return [];
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;
        $value = explode('","', mb_substr($value, 1, -1));

        return array_map(
            'stripslashes',
            $value
        );
    }

    public function getName(): string
    {
        return self::SIMPLE_STRING_ARRAY;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
