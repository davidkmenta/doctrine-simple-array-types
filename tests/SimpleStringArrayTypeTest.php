<?php declare(strict_types=1);

namespace DavidKmenta\DoctrineSimpleArrayTypes\Tests;

use DavidKmenta\DoctrineSimpleArrayTypes\SimpleStringArrayType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class SimpleStringArrayTypeTest extends TestCase
{
    /** @var Type */
    private $type;

    protected function setUp(): void
    {
        if (!SimpleStringArrayType::hasType(SimpleStringArrayType::SIMPLE_STRING_ARRAY)) {
            SimpleStringArrayType::addType(
                SimpleStringArrayType::SIMPLE_STRING_ARRAY,
                SimpleStringArrayType::class
            );
        }

        $this->type = SimpleStringArrayType::getType(SimpleStringArrayType::SIMPLE_STRING_ARRAY);
    }

    public function testShouldConvertToPHPValue(): void
    {
        $this->assertSame(
            ['key', 'wo"rd', '4,\'ever', '"foo","bar"'],
            $this->type->convertToPHPValue(
                '"key","wo\"rd","4,\\\'ever","\"foo\",\"bar\""',
                new PostgreSqlPlatform()
            )
        );
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        $this->assertSame(
            '"key","wo\"rd","4,\\\'ever","\"foo\",\"bar\""',
            $this->type->convertToDatabaseValue(
                ['key', 'wo"rd', '4,\'ever', '"foo","bar"'],
                new PostgreSqlPlatform()
            )
        );
    }
}
