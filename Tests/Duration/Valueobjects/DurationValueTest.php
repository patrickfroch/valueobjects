<?php

/**
 * @since       11.03.2024 - 14:14
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Duration\Valueobjects;

use Esit\Valueobjects\Classes\Duration\Services\Calculators\DurationCalculator;
use Esit\Valueobjects\Classes\Duration\Services\Factories\DurationFactory;
use Esit\Valueobjects\Classes\Duration\Services\Parser\DurationParser;
use Esit\Valueobjects\Classes\Duration\Valueobjects\DurationValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DurationValueTest extends TestCase
{


    /**
     * @var int
     */
    private int $time = 0;


    /**
     * @var string
     */
    private string $format = 'H:i:s';


    /**
     * @var string
     */
    private string $prefix = '-';


    /**
     * @var DurationCalculator|(DurationCalculator&MockObject)|MockObject
     */
    private DurationCalculator $calculator;


    /**
     * @var DurationParser|(DurationParser&MockObject)|MockObject
     */
    private DurationParser $converter;


    /**
     * @var DurationFactory|(DurationFactory&MockObject)|MockObject
     */
    private DurationFactory $factory;


    /**
     * @var DurationValue
     */
    private DurationValue $duration;


    protected function setUp(): void
    {
        $this->time         = 3723;

        $this->calculator   = $this->getMockBuilder(DurationCalculator::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->converter    = $this->getMockBuilder(DurationParser::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->factory      = $this->getMockBuilder(DurationFactory::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->calculator->method('getAbsoluteTime')
                         ->willReturn(\abs($this->time));

        $this->duration = new DurationValue(
            $this->time,
            $this->format,
            $this->prefix,
            $this->factory,
            $this->calculator,
            $this->converter
        );
    }


    public function testValue(): void
    {
        $this->assertSame($this->time, $this->duration->value());
    }


    public function testToString(): void
    {
        $expected = '01:02:03';

        $this->converter->expects($this->once())
                        ->method('parseString')
                        ->with($this->duration, 'H:i:s', '-')
                        ->willReturn($expected);

        $this->assertSame($expected, $this->duration->__toString());
    }


    public function testIsNegativReturnFalseIfTimeIsNegativ(): void
    {
        $this->assertFalse($this->duration->isNegativ());
    }


    public function testIsNegativReturnTrueIfTimeIsPositiv(): void
    {
        $time       = \time() * -1;
        $duration   = new DurationValue(
            $time,
            $this->format,
            $this->prefix,
            $this->factory,
            $this->calculator,
            $this->converter
        );
        $this->assertTrue($duration->isNegativ());
    }


    public function testGetFormatedUseDefaultParameter(): void
    {
        $expected = '01:02:03';

        $this->converter->expects($this->once())
                        ->method('parseString')
                        ->with($this->duration, $this->format, '-')
                        ->willReturn($expected);

        $this->assertSame($expected, $this->duration->parse($this->format));
    }


    public function testGetFormatedUseIndividualParameter(): void
    {
        $expected   = '01-02_03';
        $format     = 'H-i_s';
        $prefix     = '#';

        $this->converter->expects($this->once())
                        ->method('parseString')
                        ->with($this->duration, $format, $prefix)
                        ->willReturn($expected);

        $this->assertSame($expected, $this->duration->parse($format, $prefix));
    }


    public function testAdd(): void
    {
        $expected = 12;

        $this->calculator->expects($this->once())
                         ->method('add')
                         ->with($this->time, $this->time)
                         ->willReturn($expected);

        $this->factory->expects($this->once())
                      ->method('createDurationFromInt')
                      ->with($expected)
                      ->willReturn($this->duration);

        $this->assertSame($this->duration, $this->duration->add($this->duration));
    }


    public function testSubtract(): void
    {
        $expected = 12;

        $this->calculator->expects($this->once())
                         ->method('subtract')
                         ->with($this->time, $this->time)
                         ->willReturn($expected);

        $this->factory->expects($this->once())
                      ->method('createDurationFromInt')
                      ->with($expected)
                      ->willReturn($this->duration);

        $this->assertSame($this->duration, $this->duration->subtract($this->duration));
    }


    public function testMultiply(): void
    {
        $operand    = 12;
        $expected   = $this->time + $operand;

        $this->calculator->expects($this->once())
                         ->method('multiply')
                         ->with($this->time, $operand)
                         ->willReturn($expected);

        $this->factory->expects($this->once())
                      ->method('createDurationFromInt')
                      ->with($expected)
                      ->willReturn($this->duration);

        $this->assertSame($this->duration, $this->duration->multiply($operand));
    }


    public function testDivide(): void
    {
        $operand    = 12;
        $expected   = $this->time + $operand;

        $this->calculator->expects($this->once())
                         ->method('divide')
                         ->with($this->time, $operand)
                         ->willReturn($expected);

        $this->factory->expects($this->once())
                      ->method('createDurationFromInt')
                      ->with($expected)
                      ->willReturn($this->duration);

        $this->assertSame($this->duration, $this->duration->divide($operand));
    }
}
