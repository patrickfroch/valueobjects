<?php

/**
 * @since       12.03.2024 - 14:06
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Duration\Services\Converter;

use Esit\Valueobjects\Classes\Duration\Library\ConversionFactors;
use Esit\Valueobjects\Classes\Duration\Services\Calculators\DurationCalculator;
use Esit\Valueobjects\Classes\Duration\Services\Converter\DurationConverter;
use Esit\Valueobjects\EsitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class DurationConverterTest extends EsitTestCase
{


    /**
     * @var (DurationCalculator&MockObject)|MockObject
     */
    private $calculator;


    /**
     * @var DurationConverter
     */
    private DurationConverter $converter;


    protected function setUp(): void
    {
        $this->calculator   = $this->getMockBuilder(DurationCalculator::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->converter    = new DurationConverter($this->calculator);
    }

    public function testGetCountOfUnit(): void
    {
        $time                       = 3725;
        $rest                       = 5;
        $timeOfMinutes              = 120;
        $timeOfHour                 = 3600;
        $restOfHour                 = $time - $timeOfHour;
        $conversionFactor           = ConversionFactors::SECONDS_PER_MINUTE;
        $conversionFactorParentUnit = ConversionFactors::SECONDS_PER_HOUR;
        $expected                   = 2;

        $this->addConsecutiveReturn(
            $this->calculator,
            'modulo',
            [$restOfHour, $rest],
            [
                [$time, $timeOfHour],
                [$restOfHour, $conversionFactor]
            ]
        );

        $this->addConsecutiveReturn(
            $this->calculator,
            'subtract',
            [$timeOfHour, $restOfHour, $timeOfMinutes],
            [
                [$time, $restOfHour],
                [$time, $timeOfHour],
                [$restOfHour, $rest]
            ]
        );

        $this->calculator->expects($this->once())
                         ->method('divide')
                         ->with($timeOfMinutes, $conversionFactor)
                         ->willReturn($expected);

        $rtn = $this->converter->getCountOfUnit($time, $conversionFactor, $conversionFactorParentUnit);

        $this->assertSame($expected, $rtn);
    }


    public function testGetTotalAmountOfUnit(): void
    {
        $time               = 125;
        $rest               = 5;
        $secOfUnit          = $time - $rest;
        $conversionFactor   = ConversionFactors::SECONDS_PER_MINUTE;
        $expected           = (int) ($secOfUnit / $conversionFactor);

        $this->calculator->expects($this->once())
                     ->method('modulo')
                     ->with($time, $conversionFactor)
                     ->willReturn($rest);

        $this->calculator->expects($this->once())
                         ->method('subtract')
                         ->with($time, $rest)
                         ->willReturn($secOfUnit);

        $this->calculator->expects($this->once())
                         ->method('divide')
                         ->with($secOfUnit, $conversionFactor)
                         ->willReturn($expected);

        $rtn = $this->converter->getTotalAmountOfUnit($time, $conversionFactor);

        $this->assertSame($expected, $rtn);
    }


    public function testGetSecondsOfUnit(): void
    {
        $time               = 125;
        $rest               = 5;
        $expected           = $time - $rest;
        $conversionFactor   = ConversionFactors::SECONDS_PER_MINUTE;

        $this->calculator->expects($this->once())
                         ->method('modulo')
                         ->with($time, $conversionFactor)
                         ->willReturn($rest);

        $this->calculator->expects($this->once())
                         ->method('subtract')
                         ->with($time, $rest)
                         ->willReturn($expected);

        $rtn = $this->converter->getSecondsOfUnit($time, $conversionFactor);

        $this->assertSame($expected, $rtn);
    }


    public function testGetRestOfUnit(): void
    {
        $time               = 125;
        $conversionFactor   = ConversionFactors::SECONDS_PER_MINUTE;
        $expected           = 5;

        $this->calculator->expects($this->once())
                         ->method('modulo')
                         ->with($time, $conversionFactor)
                         ->willReturn($expected);

        $rtn = $this->converter->getRestOfUnit($time, $conversionFactor);

        $this->assertSame($expected, $rtn);
    }
}
