<?php

/**
 * @since       12.03.2024 - 12:54
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Duration\Services\Parser;

use Esit\Valueobjects\Classes\Duration\Library\DurationFormatParts;
use Esit\Valueobjects\Classes\Duration\Services\Converter\DurationConverter;
use Esit\Valueobjects\Classes\Duration\Services\Helper\DurationParserHelper;
use Esit\Valueobjects\Classes\Duration\Services\Parser\DurationParser;
use Esit\Valueobjects\Classes\Duration\Valueobjects\DurationValue;
use Esit\Valueobjects\EsitTestCase;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;

#[AllowMockObjectsWithoutExpectations]
class DurationParserTest extends EsitTestCase
{


    /**
     * @var (DurationConverter&MockObject)|MockObject
     */
    private $parserHelper;


    /**
     * @var DurationParser
     */
    private DurationParser $parser;


    protected function setUp(): void
    {
        $this->parserHelper    = $this->getMockBuilder(DurationParserHelper::class)
                                      ->disableOriginalConstructor()
                                      ->getMock();

        $this->parser           = new DurationParser($this->parserHelper);
    }


    public function testParseValueReturnString(): void
    {
        $time           = 10;
        $addLeadingZero = true;
        $rtn            = $this->parser->parseValue($time, $addLeadingZero);
        $this->assertSame((string) $time, $rtn);
    }


    public function testParseValueAddNoLeadingZeroWithSecondParameterIsFalse(): void
    {
        $time           = 9;
        $addLeadingZero = false;
        $rtn            = $this->parser->parseValue($time, $addLeadingZero);
        $this->assertSame((string) $time, $rtn);
    }


    public function testParseValueAddLeadingZeroWithSecondParameterIsTrue(): void
    {
        $time           = 9;
        $addLeadingZero = true;
        $rtn            = $this->parser->parseValue($time, $addLeadingZero);
        $this->assertSame("0$time", $rtn);
    }


    public function testParseStringParseAll(): void
    {
        $time       = 60;
        $format     = 'W-D-d-H-h-I-i-S-s';
        $expected   = "$time-$time-$time-$time-$time-$time-$time-$time-$time";

        $value      = $this->getMockBuilder(DurationValue::class)
                           ->disableOriginalConstructor()
                           ->getMock();

        $value->expects($this->once())
              ->method('isNegativ')
              ->willReturn(false);

        $value->expects($this->exactly(9))
              ->method('value')
              ->willReturn($time);

        $this->parserHelper->expects($this->exactly(9))
                           ->method('parseToken')
                           ->with(...$this->consecutiveParams(
                               [DurationFormatParts::W, $time],
                               [DurationFormatParts::D, $time],
                               [DurationFormatParts::d, $time],
                               [DurationFormatParts::H, $time],
                               [DurationFormatParts::h, $time],
                               [DurationFormatParts::I, $time],
                               [DurationFormatParts::i, $time],
                               [DurationFormatParts::S, $time],
                               [DurationFormatParts::s, $time]
                           ))
                           ->willReturn($time);

        $this->assertSame($expected, $this->parser->parseString($value, $format));
    }
}
