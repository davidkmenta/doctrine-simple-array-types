<?php declare(strict_types=1);

namespace DavidKmenta\DoctrineSimpleArrayTypes\Tests;

use DavidKmenta\DoctrineSimpleArrayTypes\SimpleIntegerArrayType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\UnexpectedResultException;
use PHPUnit\Framework\TestCase;

class SimpleIntegerArrayTypeTest extends TestCase
{
    /** @var Type */
    private $type;

    protected function setUp(): void
    {
        if (!SimpleIntegerArrayType::hasType(SimpleIntegerArrayType::SIMPLE_INTEGER_ARRAY)) {
            SimpleIntegerArrayType::addType(
                SimpleIntegerArrayType::SIMPLE_INTEGER_ARRAY,
                SimpleIntegerArrayType::class
            );
        }

        $this->type = SimpleIntegerArrayType::getType(SimpleIntegerArrayType::SIMPLE_INTEGER_ARRAY);
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
            'correct value' => ['1234,97373,3333', [1234, 97373, 3333]],
        ];
    }

    public function testShouldThrowExceptionIfValueCannotBeSafelyConverted(): void
    {
        $this->expectException(UnexpectedResultException::class);
        $this->expectExceptionMessage('Value "123,,999" cannot be converted into array of integers!');

        $this->type->convertToPHPValue('123,,999', new PostgreSqlPlatform());
    }
}
