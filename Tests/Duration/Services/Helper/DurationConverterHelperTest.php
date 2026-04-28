<?php

/**
 * @since       19.03.2024 - 13:45
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Duration\Services\Helper;

use Esit\Valueobjects\Classes\Duration\Library\ConversionFactors;
use Esit\Valueobjects\Classes\Duration\Services\Calculators\DurationCalculator;
use Esit\Valueobjects\Classes\Duration\Services\Converter\DurationConverter;
use Esit\Valueobjects\Classes\Duration\Services\Helper\DurationConverterHelper;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[AllowMockObjectsWithoutExpectations]
class DurationConverterHelperTest extends TestCase
{


    /**
     * @var (DurationCalculator&MockObject)|MockObject
     */
    private $calculator;


    /**
     * @var (DurationConverter&MockObject)|MockObject
     */
    private $converter;


    /**
     * @var int
     */
    private $time = 0;


    /**
     * @var DurationConverterHelper
     */
    private DurationConverterHelper $helper;


    protected function setUp(): void
    {
        $this->time         = \time();

        $this->calculator   = $this->getMockBuilder(DurationCalculator::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->converter    = $this->getMockBuilder(DurationConverter::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->helper       = new DurationConverterHelper($this->calculator, $this->converter);
    }

    public function testGetTotalYears(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $this->converter->expects($this->once())
                        ->method('getTotalAmountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_YEAR)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getTotalYears($this->time));
    }

    public function testGetMonthsCount(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $this->converter->expects($this->once())
                        ->method('getCountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_MONTH, ConversionFactors::SECONDS_PER_YEAR)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getMonthsCount($this->time));
    }

    public function testGetTotalMonths(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $this->converter->expects($this->once())
                        ->method('getTotalAmountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_MONTH)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getTotalMonths($this->time));
    }

    public function testGetWeeksCount(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $this->converter->expects($this->once())
                        ->method('getCountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_WEEK, ConversionFactors::SECONDS_PER_MONTH)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getWeeksCount($this->time));
    }

    public function testGetTotalWeeks(): void
    {
        $this->converter->expects($this->once())
                        ->method('getTotalAmountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_WEEK)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getTotalWeeks($this->time));
    }

    public function testGetDaysCount(): void
    {
        $this->converter->expects($this->once())
                        ->method('getCountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_DAY, ConversionFactors::SECONDS_PER_WEEK)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getDaysCount($this->time));
    }

    public function testGetTotalDays(): void
    {
        $this->converter->expects($this->once())
                        ->method('getTotalAmountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_DAY)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getTotalDays($this->time));
    }

    public function testGetHoursCount(): void
    {
        $this->converter->expects($this->once())
                        ->method('getCountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_HOUR, ConversionFactors::SECONDS_PER_DAY)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getHoursCount($this->time));
    }

    public function testGetTotalHours(): void
    {
        $this->converter->expects($this->once())
                        ->method('getTotalAmountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_HOUR)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getTotalHours($this->time));
    }

    public function testGetMinutesCount(): void
    {
        $this->converter->expects($this->once())
                        ->method('getCountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_MINUTE, ConversionFactors::SECONDS_PER_HOUR)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getMinutesCount($this->time));
    }

    public function testGetTotalMinutes(): void
    {
        $this->converter->expects($this->once())
                        ->method('getTotalAmountOfUnit')
                        ->with($this->time, ConversionFactors::SECONDS_PER_MINUTE)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getTotalMinutes($this->time));
    }

    public function testGetSconds(): void
    {
        $this->calculator->expects($this->once())
                         ->method('modulo')
                         ->with($this->time, ConversionFactors::SECONDS_PER_MINUTE)
                         ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->getSconds($this->time));
    }
}
