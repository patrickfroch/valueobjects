<?php

/**
 * @since       03.08.2022 - 11:12
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Money\Services\Converter;

use Esit\Valueobjects\Classes\Money\Exceptions\MoneyIsEmptyException;
use Esit\Valueobjects\Classes\Money\Exceptions\NotAValidMoneyStringException;
use Esit\Valueobjects\Classes\Money\Services\Converter\MoneyConverter;
use Esit\Valueobjects\Classes\Money\Services\Validators\MoneyValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MoneyConverterTest extends TestCase
{

    /**
     * @var MoneyValidator|MoneyValidator&MockObject|MockObject
     */
    private $validator;


    /**
     * @var MoneyConverter
     */
    private MoneyConverter $converter;


    protected function setUp(): void
    {
        $this->validator    = $this->getMockBuilder(MoneyValidator::class)->disableOriginalConstructor()->getMock();
        $this->converter    = new MoneyConverter($this->validator);
    }


    public function testConvertStringToIntThrowExceptionIfValueIsEmpty(): void
    {
        $this->expectException(MoneyIsEmptyException::class);
        $this->expectExceptionMessage('Money string can not be empty');
        $this->converter->convertStringToInt('');
    }


    public function testConvertStringToIntThrowExceptionIfValueIsNoValidMoneyString(): void
    {
        $this->expectException(NotAValidMoneyStringException::class);
        $this->expectExceptionMessage('Parameter is not a valid money string');

        $value = '1T0';
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with($value, '.', ',')
                        ->willReturn(false);

        $this->converter->convertStringToInt($value);
    }


    public function testConvertStringToIntReturnIntegerIfValueIsValid(): void
    {
        $value = '1.234,56';
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with($value, '.', ',')
                        ->willReturn(true);

        $rtn = $this->converter->convertStringToInt($value);
        $this->assertSame(123456, $rtn);
    }


    public function testConvertStringToIntReturnIntegerIfSignsNotFound(): void
    {
        $value = '123456';
        $this->validator->expects($this->once())
                         ->method('isValidString')
                         ->with($value, '.', ',')
                         ->willReturn(true);

        $rtn = $this->converter->convertStringToInt($value);
        $this->assertSame((int) $value, $rtn);
    }


    public function testConvertStringToIntReturnIntegerWithIndividualSigns(): void
    {
        $value = '1-234|56';
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with($value, '-', '|')
                        ->willReturn(true);

        $rtn = $this->converter->convertStringToInt($value, '-', '|');
        $this->assertSame(123456, $rtn);
    }


    public function testConvertStringToIntReturnIntegerWithoutSigns(): void
    {
        $value = '123456';
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with($value, '', '')
                        ->willReturn(true);

        $rtn = $this->converter->convertStringToInt($value, '', '');
        $this->assertSame(123456, $rtn);
    }


    public function testConvertIntToStringThrowExceptionIfValueIsLessZero(): void
    {
        $this->expectException(NotAValidMoneyStringException::class);
        $this->expectExceptionMessage('Parameter is not a valid integer');
        $this->validator->expects($this->once())->method('isValidInt')->with(-1)->willReturn(false);
        $this->converter->convertIntToString(-1);
    }


    public function testConvertIntToStringReturnZeroStringIfValueIsZero(): void
    {
        $this->validator->expects($this->once())->method('isValidInt')->with(0)->willReturn(true);
        $rtn = $this->converter->convertIntToString(0);
        $this->assertSame('0,00', $rtn);
    }


    public function testConvertIntToStringReturnRightStringIfValueIsNotZero(): void
    {
        $this->validator->expects($this->once())->method('isValidInt')->with(123456)->willReturn(true);
        $rtn = $this->converter->convertIntToString(123456);
        $this->assertSame('1.234,56', $rtn);
    }


    public function testConvertIntToStringReturnRightStringIfValueIsNotZeroWithIndividualSigns(): void
    {
        $this->validator->expects($this->once())->method('isValidInt')->with(123456)->willReturn(true);
        $rtn = $this->converter->convertIntToString(123456, '-', '|');
        $this->assertSame('1-234|56', $rtn);
    }


    public function testConvertIntToStringReturnRightStringIfValueIsNotZeroWithoutSigns(): void
    {
        $this->validator->expects($this->once())->method('isValidInt')->with(123456)->willReturn(true);
        $rtn = $this->converter->convertIntToString(123456, '', '');
        $this->assertSame('123456', $rtn);
    }


    public function testConvertIntToStringReturnRightStringIfValueIsNotZeroWithIndividualSettings(): void
    {
        $this->validator->expects($this->once())->method('isValidInt')->with(123456789)->willReturn(true);
        $rtn = $this->converter->convertIntToString(123456789, '.', ',', 3);
        $this->assertSame('123.456,789', $rtn);
    }
}
