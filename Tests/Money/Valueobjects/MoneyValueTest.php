<?php

/**
 * @since       31.07.2022 - 12:58
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Money\Valueobjects;

use Esit\Valueobjects\Classes\Money\Exceptions\NotAValidMoneyStringException;
use Esit\Valueobjects\Classes\Money\Services\Calculator\MoneyCalculator;
use Esit\Valueobjects\Classes\Money\Services\Converter\MoneyConverter;
use Esit\Valueobjects\Classes\Money\Services\Validators\MoneyValidator;
use Esit\Valueobjects\Classes\Money\Valueobjects\MoneyValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MoneyValueTest extends TestCase
{

    /**
     * @var MoneyValidator&MockObject
     */
    private MoneyValidator $validator;


    /**
     * @var MoneyConverter&MockObject
     */
    private MoneyConverter $converter;


    /**
     * @var MoneyCalculator&MockObject
     */
    private MoneyCalculator $calculator;


    /**
     * @var MoneyValue
     */
    private MoneyValue $money;


    protected function setUp(): void
    {
        $this->validator    = $this->getMockBuilder(MoneyValidator::class)->disableOriginalConstructor()->getMock();
        $this->converter    = $this->getMockBuilder(MoneyConverter::class)->disableOriginalConstructor()->getMock();
        $this->calculator   = $this->getMockBuilder(MoneyCalculator::class)->disableOriginalConstructor()->getMock();
    }


    public function testGetDecimalPlaces(): void
    {
        $money = MoneyValue::fromInt(0, $this->converter, $this->calculator, 3);
        $this->assertSame(3, $money->getDecimalPlaces());
    }


    public function testFromStringThrowExceptionIFStringIsNoValidMoneyString(): void
    {
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with('0-0', '.', ',')
                        ->willReturn(false);

        $this->converter->expects($this->never())
                        ->method('convertStringToInt');

        $this->expectException(NotAValidMoneyStringException::class);
        $this->expectExceptionMessage('Value is no Valid money string');
        $money = MoneyValue::fromString('0-0', $this->converter, $this->validator, $this->calculator);
        $this->assertNotNull($money);
    }


    public function testFromStringReturnMoneyObjectWithDefaultSettings(): void
    {
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with('0,00', '.', ',')
                        ->willReturn(true);

        $this->converter->expects($this->once())
                        ->method('convertStringToInt')
                        ->with('0,00', '.', ',')
                        ->willReturn(0);

        $money = MoneyValue::fromString('0,00', $this->converter, $this->validator, $this->calculator);
        $this->assertNotNull($money);
    }


    public function testFromStringReturnMoneyObjectWithIndividualSettings(): void
    {
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with('0,000', '|', '-')
                        ->willReturn(true);

        $this->converter->expects($this->once())
                        ->method('convertStringToInt')
                        ->with('0,000', '|', '-')
                        ->willReturn(0);

        $money = MoneyValue::fromString('0,000', $this->converter, $this->validator, $this->calculator, '|', '-', 3);
        $this->assertNotNull($money);
    }


    public function testFromIntReturnObject(): void
    {
        $money = MoneyValue::fromInt(0, $this->converter, $this->calculator, 3);
        $this->assertNotNull($money);
    }


    public function testValueReturnInteger(): void
    {
        $money = MoneyValue::fromInt(12, $this->converter, $this->calculator);
        $this->assertSame(12, $money->value());
    }


    public function testToStringReturnFormatedString(): void
    {
        $money = MoneyValue::fromInt(1200000, $this->converter, $this->calculator);

        $this->converter->expects($this->once())
                        ->method('convertIntToString')
                        ->with(1200000, '.', ',')
                        ->willReturn('12.000,00');

        $this->assertSame('12.000,00', (string) $money);
    }


    public function testFormatedValueReturnFormatedString(): void
    {
        $money = MoneyValue::fromInt(1200000, $this->converter, $this->calculator);

        $this->converter->expects($this->once())
                        ->method('convertIntToString')
                        ->with(1200000, '.', ',')
                        ->willReturn('12.000,00');

        $this->assertSame('12.000,00', $money->formatedValue());
    }


    public function testFormatedValueReturnStringWithDifferentSeparator(): void
    {
        $money = MoneyValue::fromInt(1200000, $this->converter, $this->calculator);

        $this->converter->expects($this->once())
                        ->method('convertIntToString')
                        ->with(1200000, '-', ',')
                        ->willReturn('12-000,00');

        $this->assertSame('12-000,00', $money->formatedValue('-'));
    }


    public function testFormatedValueReturnStringWithDifferentDecimalSign(): void
    {
        $money = MoneyValue::fromInt(1200000, $this->converter, $this->calculator);

        $this->converter->expects($this->once())
                        ->method('convertIntToString')
                        ->with(1200000, '.', '/')
                        ->willReturn('12.000/00');

        $this->assertSame('12.000/00', $money->formatedValue('.', '/'));
    }


    public function testAddTakeTowObjectsAndReturnsTheResult(): void
    {
        $money      = MoneyValue::fromInt(12, $this->converter, $this->calculator);
        $moneyTwo   = MoneyValue::fromInt(24, $this->converter, $this->calculator);

        $this->calculator->expects($this->once())
                         ->method('add')
                         ->with($money, $moneyTwo)
                         ->willReturn(36);

        $rtn = $money->add($moneyTwo);
        $this->assertSame(12, $money->value());
        $this->assertSame(36, $rtn->value());
    }


    public function testSubstractTakeTowObjectsAndReturnsTheResult(): void
    {
        $moneyOne   = MoneyValue::fromInt(36, $this->converter, $this->calculator);
        $moneyTwo   = MoneyValue::fromInt(24, $this->converter, $this->calculator);

        $this->calculator->expects($this->once())
                         ->method('substract')
                         ->with($moneyOne, $moneyTwo)
                         ->willReturn(12);

        $rtn = $moneyOne->substract($moneyTwo);
        $this->assertSame(36, $moneyOne->value());
        $this->assertSame(24, $moneyTwo->value());
        $this->assertSame(12, $rtn->value());
    }


    public function testMultiplyTakeAnObjectAndANumberAndReturnsTheResult(): void
    {
        $money = MoneyValue::fromInt(12, $this->converter, $this->calculator);

        $this->calculator->expects($this->once())
                         ->method('multiply')
                         ->with($money, 3)
                         ->willReturn(36);

        $rtn = $money->multiply(3);
        $this->assertSame(12, $money->value());
        $this->assertSame(36, $rtn->value());
    }


    public function testDivideTakeAnObjectAndANumberAndReturnsTheResult(): void
    {
        $money = MoneyValue::fromInt(36, $this->converter, $this->calculator);

        $this->calculator->expects($this->once())
                         ->method('divide')
                         ->with($money, 3)
                         ->willReturn(12);

        $rtn = $money->divide(3);
        $this->assertSame(36, $money->value());
        $this->assertSame(12, $rtn->value());
    }
}
