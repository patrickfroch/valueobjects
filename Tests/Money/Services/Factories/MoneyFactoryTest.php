<?php

/**
 * @since       31.07.2022 - 18:35
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Money\Services\Factories;

use Esit\Valueobjects\Classes\Money\Services\Calculator\MoneyCalculator;
use Esit\Valueobjects\Classes\Money\Services\Converter\MoneyConverter;
use Esit\Valueobjects\Classes\Money\Services\Factories\MoneyFactory;
use Esit\Valueobjects\Classes\Money\Services\Validators\MoneyValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MoneyFactoryTest extends TestCase
{

    /**
     * @var MoneyConverter|MockObject
     */
    private $converter;


    /**
     * @var MoneyValidator|MockObject
     */
    private $validator;


    /**
     * @var MoneyFactory
     */
    private MoneyFactory $factory;


    protected function setUp(): void
    {
        $this->validator    = $this->getMockBuilder(MoneyValidator::class)->disableOriginalConstructor()->getMock();
        $this->converter    = $this->getMockBuilder(MoneyConverter::class)->disableOriginalConstructor()->getMock();
        $calculator         = $this->getMockBuilder(MoneyCalculator::class)->disableOriginalConstructor()->getMock();
        $this->factory      = new MoneyFactory($this->converter, $this->validator, $calculator);
    }


    public function testCreateFromIntReturnAnObject(): void
    {
        $this->assertNotNull($this->factory->createFromInt(12, 3));
    }


    public function testCreateFromStringReturnAnObjectWithDefaultSettings(): void
    {
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with('12.345,67', '.', ',', 2)
                        ->willReturn(true);

        $this->converter->expects($this->once())
                        ->method('convertStringToInt')
                        ->with('12.345,67', '.', ',')
                        ->willReturn(1234567);

        $this->assertNotNull($this->factory->createFromString('12.345,67'));
    }


    public function testCreateFromStringReturnAnObjectWithIndividualSettings(): void
    {
        $this->validator->expects($this->once())
                        ->method('isValidString')
                        ->with('12.345,678', '|', '-', 3)
                        ->willReturn(true);

        $this->converter->expects($this->once())
                        ->method('convertStringToInt')
                        ->with('12.345,678', '|', '-')
                        ->willReturn(12345678);

        $this->assertNotNull($this->factory->createFromString('12.345,678', '|', '-', 3));
    }
}
