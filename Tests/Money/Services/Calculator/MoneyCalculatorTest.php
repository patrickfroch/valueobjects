<?php

/**
 * @since       03.08.2022 - 11:46
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Money\Services\Calculator;

use Esit\Valueobjects\Classes\Money\Exceptions\DivisionByZeroException;
use Esit\Valueobjects\Classes\Money\Exceptions\NotSameDecimalPlacesException;
use Esit\Valueobjects\Classes\Money\Services\Calculator\MoneyCalculator;
use Esit\Valueobjects\Classes\Money\Valueobjects\MoneyValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MoneyCalculatorTest extends TestCase
{

    /**
     * @var MoneyValue&MockObject|MockObject
     */
    private $moneyOne;


    /**
     * @var MoneyValue&MockObject|MockObject
     */
    private $moneyTwo;


    /**
     * @var MoneyCalculator
     */
    private $calculator;


    protected function setUp(): void
    {
        $this->moneyOne = $this->getMockBuilder(MoneyValue::class)->disableOriginalConstructor()->getMock();
        $this->moneyTwo = $this->getMockBuilder(MoneyValue::class)->disableOriginalConstructor()->getMock();
        $this->calculator   = new MoneyCalculator();
    }


    public function testAddThrowExceptionIfDecimalPlacesNotTheSame(): void
    {
        $this->moneyOne->expects($this->once())->method('getDecimalPlaces')->willReturn(2);
        $this->moneyTwo->expects($this->once())->method('getDecimalPlaces')->willReturn(3);
        $this->moneyOne->expects($this->never())->method('value');
        $this->moneyTwo->expects($this->never())->method('value');
        $this->expectException(NotSameDecimalPlacesException::class);
        $this->expectExceptionMessage('money objects must have the same decimal place count');
        $this->calculator->add($this->moneyOne, $this->moneyTwo);
    }


    public function testAddTakeTowObjectsAndReturnsTheResult(): void
    {
        $this->moneyOne->expects($this->once())->method('value')->willReturn(12);
        $this->moneyTwo->expects($this->once())->method('value')->willReturn(24);
        $this->assertSame(36, $this->calculator->add($this->moneyOne, $this->moneyTwo));
    }


    public function testSubstractThrowExceptionIfDecimalPlacesNotTheSame(): void
    {
        $this->moneyOne->expects($this->never())->method('value');
        $this->moneyTwo->expects($this->never())->method('value');
        $this->moneyOne->expects($this->once())->method('getDecimalPlaces')->willReturn(2);
        $this->moneyTwo->expects($this->once())->method('getDecimalPlaces')->willReturn(3);
        $this->expectException(NotSameDecimalPlacesException::class);
        $this->expectExceptionMessage('money objects must have the same decimal place count');
        $this->calculator->substract($this->moneyOne, $this->moneyTwo);
    }


    public function testSubstractTakeTowObjectsAndReturnsTheResult(): void
    {
        $this->moneyOne->expects($this->once())->method('value')->willReturn(12);
        $this->moneyTwo->expects($this->once())->method('value')->willReturn(24);
        $this->assertSame(-12, $this->calculator->substract($this->moneyOne, $this->moneyTwo));
    }


    public function testMultiplyTakeAnObjectAndANumberAndReturnsTheResult(): void
    {
        $this->moneyOne->expects($this->once())->method('value')->willReturn(12);
        $this->moneyTwo->expects($this->never())->method('value');
        $this->assertSame(24, $this->calculator->multiply($this->moneyOne, 2));
    }


    public function testMultiplyReturnZeroIfIntIsZero(): void
    {
        $this->moneyOne->expects($this->once())->method('value')->willReturn(12);
        $this->moneyTwo->expects($this->never())->method('value');
        $this->assertSame(0, $this->calculator->multiply($this->moneyOne, 0));
    }


    public function testMultiplyReturnZeroIfMoneyIsZero(): void
    {
        $this->moneyOne->expects($this->once())->method('value')->willReturn(0);
        $this->moneyTwo->expects($this->never())->method('value');
        $this->assertSame(0, $this->calculator->multiply($this->moneyOne, 2));
    }


    public function testDivideThrowExceptionIfIntIsZero(): void
    {
        $this->expectException(DivisionByZeroException::class);
        $this->expectExceptionMessage('division by zero not possible');
        $this->moneyOne->expects($this->never())->method('value');
        $this->moneyTwo->expects($this->never())->method('value');
        $this->assertSame(0, $this->calculator->divide($this->moneyOne, 0));
    }


    public function testDivideReturnZeroIfMoneyIsZero(): void
    {
        $this->moneyOne->expects($this->once())->method('value')->willReturn(0);
        $this->moneyTwo->expects($this->never())->method('value');
        $this->assertSame(0, $this->calculator->divide($this->moneyOne, 2));
    }


    public function testDivideReturnIntIfMoneyIsNotZero(): void
    {
        $this->moneyOne->expects($this->once())->method('value')->willReturn(12);
        $this->moneyTwo->expects($this->never())->method('value');
        $this->assertSame(6, $this->calculator->divide($this->moneyOne, 2));
    }
}
