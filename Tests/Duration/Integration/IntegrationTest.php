<?php

/**
 * @since       12.03.2024 - 15:46
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Duration\Integration;

use Esit\Valueobjects\Classes\Duration\Services\Calculators\DurationCalculator;
use Esit\Valueobjects\Classes\Duration\Services\Converter\DurationConverter;
use Esit\Valueobjects\Classes\Duration\Services\Factories\DurationFactory;
use Esit\Valueobjects\Classes\Duration\Services\Helper\DurationConverterHelper;
use Esit\Valueobjects\Classes\Duration\Services\Helper\DurationParserHelper;
use Esit\Valueobjects\Classes\Duration\Services\Parser\DurationParser;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{


    /**
     * @var string
     */
    private string $format = 'W-d h:i:s';


    /**
     * @var DurationFactory
     */
    private DurationFactory $factory;


    protected function setUp(): void
    {
        $calculator         = new DurationCalculator();
        $converter          = new DurationConverter($calculator);
        $converterHelper    = new DurationConverterHelper($calculator, $converter);
        $parserHelper       = new DurationParserHelper($converterHelper);
        $parser             = new DurationParser($parserHelper);
        $this->factory      = new DurationFactory($calculator, $parser);
    }


    public function testGetFormatedMinutesAndSeconds(): void
    {
        $time   = 2096; // 34 Minuten, 56 Sekunden
        $value  = $this->factory->createDurationFromInt($time);

        $this->assertSame('00-00 00:34:56', $value->parse($this->format));
    }


    public function testGetFormatedHoursAndMinutes(): void
    {
        $time   = 45240; // 12 Stunden, 34 Minuten
        $value  = $this->factory->createDurationFromInt($time);

        $this->assertSame('00-00 12:34:00', $value->parse($this->format));
    }


    public function testGetFormatedDaysAndHours(): void
    {
        $time   = 216000; // 2 Tage, 12 Stunden
        $value  = $this->factory->createDurationFromInt($time);

        $this->assertSame('00-02 12:00:00', $value->parse($this->format));
    }


    public function testGetFormatedWeeksAndDays(): void
    {
        $time   = 1987200; // 3 Wochen, 2 Tage
        $value  = $this->factory->createDurationFromInt($time);

        $this->assertSame('03-02 00:00:00', $value->parse($this->format));
    }


    public function testGetFormatedMonthAndWeeksAndDays(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $time   = 11491200; // 4 Monate, 3 Wochen, 0 Tage
        $value  = $this->factory->createDurationFromInt($time);

        $this->assertSame('00-04-03-00 00:00:00', $value->parse($this->format));
    }


    public function testGetFormatedYearsAndMonthAndWeeksAndDays(): void
    {
        $this->markTestSkipped('Die die Länge eines Montas nicht festgelegt ist, kann dieser Wert nicht pauschal berechnet werden!');
        $time   = 43027200; // 1 Jahr, 4 Monate, 3 Wochen, 0 Tage
        $value  = $this->factory->createDurationFromInt($time);

        $this->assertSame('01-04-03-00 00:00:00', $value->parse($this->format));
    }


    public function testGetFormatedWithNegativValue(): void
    {
        $time   = 45296 * -1; // 12 Stunden, 34 Minuten, 56 Sekunden
        $value  = $this->factory->createDurationFromInt($time);

        $this->assertSame('-00-00 12:34:56', $value->parse($this->format));
    }


    public function testGetFormatedWithIndividualPrefix(): void
    {
        $time   = 45296 * -1; // 12 Stunden, 34 Minuten, 56 Sekunden
        $value  = $this->factory->createDurationFromInt($time);

        $this->assertSame('=>56:12:34', $value->parse('s:H:i', '=>'));
    }


    public function testAdd(): void
    {
        $time       = 45296; // 12 Stunden, 34 Minuten, 56 Sekunden
        $valueOne   = $this->factory->createDurationFromInt($time);
        $valueTwo   = $this->factory->createDurationFromInt($time);
        $value      = $valueOne->add($valueTwo);

        $this->assertSame('25:09:52', $value->parse('H:i:s'));
    }


    public function testSubtract(): void
    {
        $time       = 45296; // 12 Stunden, 34 Minuten, 56 Sekunden
        $valueOne   = $this->factory->createDurationFromInt($time);
        $valueTwo   = $this->factory->createDurationFromInt($time);
        $value      = $valueOne->subtract($valueTwo);

        $this->assertSame('00-00 00:00:00', $value->parse($this->format));
    }


    public function testMultiply(): void
    {
        $time       = 45296; // 12 Stunden, 34 Minuten, 56 Sekunden
        $valueOne   = $this->factory->createDurationFromInt($time);
        $operand    = 2;
        $value      = $valueOne->multiply($operand);

        $this->assertSame('25:09:52', $value->parse('H:i:s'));
    }


    public function testDivide(): void
    {
        $time       = 45296; // 12 Stunden, 34 Minuten, 56 Sekunden
        $valueOne   = $this->factory->createDurationFromInt($time);
        $operand    = 2;
        $value      = $valueOne->divide($operand);

        $this->assertSame('00-00 06:17:28', $value->parse($this->format));
    }


    public function testDotOpposite(): void
    {
        $time       = 45296; // 12 Stunden, 34 Minuten, 56 Sekunden
        $valueOne   = $this->factory->createDurationFromInt($time);
        $operand    = 2;
        $value      = $valueOne->multiply($operand);
        $value      = $value->divide($operand);

        $this->assertSame($valueOne->parse($this->format), $value->parse($this->format));
    }


    public function testDashOpposite(): void
    {
        $time       = 45296; // 12 Stunden, 34 Minuten, 56 Sekunden
        $valueOne   = $this->factory->createDurationFromInt($time);
        $valueTwo   = $this->factory->createDurationFromInt($time);
        $value      = $valueOne->add($valueTwo);
        $value      = $value->subtract($valueTwo);

        $this->assertSame($valueOne->parse($this->format), $value->parse($this->format));
    }
}
