<?php

/**
 * @since       03.08.2022 - 10:34
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Money\Services\Validators;

use Esit\Valueobjects\Classes\Money\Exceptions\ParameterIsEmptyException;
use Esit\Valueobjects\Classes\Money\Services\Validators\MoneyValidator;
use PHPUnit\Framework\TestCase;

final class MoneyValidatorTest extends TestCase
{

    /**
     * @var MoneyValidator
     */
    private MoneyValidator $validator;


    protected function setUp(): void
    {
        $this->validator = new MoneyValidator();
    }


    public function testIsValidMonyStringReturnFalseIfSeperatorIsNotRight(): void
    {
        $this->assertFalse($this->validator->isValidString('1.000,00', '-', ','));
    }


    public function testIsValidMonyStringReturnFalseIfDecimalIsNotRight(): void
    {
        $this->assertFalse($this->validator->isValidString('1.000,00', '.', '-'));
    }


    public function testIsValidMonyStringReturnFalseIfDecimalPlacesIsNotRight(): void
    {
        $this->assertFalse($this->validator->isValidString('1.000,00', '.', ',', 3));
    }


    public function testIsValidMonyStringReturnTrueWithIndividualSigns(): void
    {
        $this->assertTrue($this->validator->isValidString('1|000-0000', '|', '-', 4));
    }


    public function testIsValidMonyStringReturnFalseIfThereAreLetters(): void
    {
        $this->assertFalse($this->validator->isValidString('1.0T0,00'));
    }


    public function testIsValidMonyStringThrowExceptionIfValueIsEmpty(): void
    {
        $this->expectException(ParameterIsEmptyException::class);
        $this->expectExceptionMessage('value could not be empty');
        $this->assertFalse($this->validator->isValidString(''));
    }


    public function testIsValidMonyStringThrowExceptionIfDecimalSignIsEmpty(): void
    {
        $this->expectException(ParameterIsEmptyException::class);
        $this->expectExceptionMessage('decimal char could not be empty');
        $this->assertFalse($this->validator->isValidString('1.000,00', '.', '', 2));
    }


    public function testIsValidMonyStringDoNotThrowExceptionIfDecimalSignIsEmptyAndDecimalPlacesAreZero(): void
    {
        $this->assertTrue($this->validator->isValidString('1.000', '.', '', 0));
    }


    public function testIsValidMonyStringReturnTrueWithStandardSigns(): void
    {
        $this->assertTrue($this->validator->isValidString('1.000,00'));
    }


    public function testIsValidMonyStringReturnTrueWithoutASeperator(): void
    {
        $this->assertTrue($this->validator->isValidString('1000,00', '', ',', 2));
    }


    public function testIsValidMonyStringReturnTrueWithZeroDecimalPlaces(): void
    {
        $this->assertTrue($this->validator->isValidString('1.000', '.', ',', 0));
    }


    public function testIsValidMonyStringReturnFalseWithTwoDecimalPlaces(): void
    {
        $this->assertFalse($this->validator->isValidString('1.000', '.', ',', 2));
    }


    public function testIsValidMonyStringReturnTrueWithoutSigns(): void
    {
        $this->assertTrue($this->validator->isValidString('1000', '', ',', 0));
    }


    public function testIsValidMonyStringReturnFalseIfThereAreTooManyDecimalPlaces(): void
    {
        $this->assertFalse($this->validator->isValidString('1000,00', '', ',', 0));
    }


    public function testIsValidIntReturnTrueIfValueIsGreaterThenZero(): void
    {
        $this->assertTrue($this->validator->isValidInt(1));
    }


    public function testIsValidIntReturnTrueIfValueIsZero(): void
    {
        $this->assertTrue($this->validator->isValidInt(0));
    }


    public function testIsValidIntReturnFalseIfValueIsLessZero(): void
    {
        $this->assertFalse($this->validator->isValidInt(-1));
    }
}
