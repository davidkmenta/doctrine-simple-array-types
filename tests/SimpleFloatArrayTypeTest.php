<?php declare(strict_types=1);

namespace DavidKmenta\DoctrineSimpleArrayTypes\Tests;

use DavidKmenta\DoctrineSimpleArrayTypes\SimpleFloatArrayType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\UnexpectedResultException;
use PHPUnit\Framework\TestCase;

class SimpleFloatArrayTypeTest extends TestCase
{
    /** @var Type */
    private $type;

    protected function setUp(): void
    {
        if (!SimpleFloatArrayType::hasType(SimpleFloatArrayType::SIMPLE_FLOAT_ARRAY)) {
            SimpleFloatArrayType::addType(
                SimpleFloatArrayType::SIMPLE_FLOAT_ARRAY,
                SimpleFloatArrayType::class
            );
        }

        $this->type = SimpleFloatArrayType::getType(SimpleFloatArrayType::SIMPLE_FLOAT_ARRAY);
    }

    public function testShouldThrowExceptionIfPhpValueCannotBeSafelyConverted(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Value "123,,999" cannot be converted into array of floats!');

        $this->type->convertToDatabaseValue([0.000001], new PostgreSqlPlatform());
    }

    /**
     * @dataProvider provideDatabaseValues
     */
    public function testShouldConvertToPHPValue(?string $value, array $expectedConvertedValue): void
    {
        $this->assertSame($expectedConvertedValue, $this->type->convertToPHPValue($value, new PostgreSqlPlatform()));
    }

    public function provideDatabaseValues(): array
    {
        return [
            'null value' => [null, []],
            'empty value' => ['', []],
            'correct value' => ['123.4,973.73,3.333,0.1,0.7,1.0E-5', [123.4, 973.73, 3.333, 0.1, 0.7, 1.0E-5]],
        ];
    }

    public function testShouldThrowExceptionIfDatabaseValueCannotBeSafelyConverted(): void
    {
        $this->expectException(UnexpectedResultException::class);
        $this->expectExceptionMessage('Value "123,,999" cannot be converted into array of floats!');

        $this->type->convertToPHPValue('123,,999', new PostgreSqlPlatform());
    }
}
