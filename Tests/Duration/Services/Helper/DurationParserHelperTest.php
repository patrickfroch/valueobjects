<?php

/**
 * @since       19.03.2024 - 13:34
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Duration\Services\Helper;

use Esit\Valueobjects\Classes\Duration\Library\DurationFormatParts;
use Esit\Valueobjects\Classes\Duration\Services\Helper\DurationConverterHelper;
use Esit\Valueobjects\Classes\Duration\Services\Helper\DurationParserHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DurationParserHelperTest extends TestCase
{


    /**
     * @var (DurationConverterHelper&MockObject)|MockObject
     */
    private $converter;


    /**
     * @var DurationParserHelper
     */
    private DurationParserHelper $helper;

    /**
     * @var int
     */
    private int $time = 0;


    protected function setUp(): void
    {
        $this->time         = \time();

        $this->converter    = $this->getMockBuilder(DurationConverterHelper::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->helper       = new DurationParserHelper($this->converter);
    }


    public function testParseTokenConvertTotalSeconds(): void
    {
        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::S, $this->time));
    }


    public function testParseTokenConvertRestSeconds(): void
    {
        $this->converter->expects($this->once())
                        ->method('getSconds')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::s, $this->time));
    }


    public function testParseTokenConvertTotalMinutes(): void
    {
        $this->converter->expects($this->once())
                        ->method('getTotalMinutes')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::I, $this->time));
    }


    public function testParseTokenConvertRestMinutes(): void
    {
        $this->converter->expects($this->once())
                        ->method('getMinutesCount')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::i, $this->time));
    }


    public function testParseTokenConvertTotalHours(): void
    {
        $this->converter->expects($this->once())
                        ->method('getTotalHours')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::H, $this->time));
    }


    public function testParseTokenConvertRestHours(): void
    {
        $this->converter->expects($this->once())
                        ->method('getHoursCount')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::h, $this->time));
    }


    public function testParseTokenConvertTotalDays(): void
    {
        $this->converter->expects($this->once())
                        ->method('getTotalDays')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::D, $this->time));
    }


    public function testParseTokenConvertRestDays(): void
    {
        $this->converter->expects($this->once())
                        ->method('getDaysCount')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::d, $this->time));
    }


    public function testParseTokenConvertTotalWeeks(): void
    {
        $this->converter->expects($this->once())
                        ->method('getTotalWeeks')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::W, $this->time));
    }


    public function testParseTokenConvertRestWeeks(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $this->converter->expects($this->once())
                        ->method('getWeeksCount')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::w, $this->time));
    }


    public function testParseTokenConvertTotalMonths(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $this->converter->expects($this->once())
                        ->method('getTotalMonths')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::M, $this->time));
    }


    public function testParseTokenConvertRestMonths(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $this->converter->expects($this->once())
                        ->method('getMonthsCount')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::m, $this->time));
    }


    public function testParseTokenConvertTotalYear(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $this->converter->expects($this->once())
                        ->method('getTotalYears')
                        ->with($this->time)
                        ->willReturn($this->time);

        $this->assertSame($this->time, $this->helper->parseToken(DurationFormatParts::Y, $this->time));
    }
}
