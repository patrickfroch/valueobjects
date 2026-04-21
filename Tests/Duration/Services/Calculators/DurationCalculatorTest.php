<?php

/**
 * @since       11.03.2024 - 15:13
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Duration\Services\Calculators;

use Esit\Valueobjects\Classes\Duration\Services\Calculators\DurationCalculator;
use PHPUnit\Framework\TestCase;

class DurationCalculatorTest extends TestCase
{


    /**
     * @var int
     */
    private int $time = 0;


    /**
     * @var DurationCalculator
     */
    private $calculator;


    protected function setUp(): void
    {
        $this->calculator   = new DurationCalculator();
        $this->time         = \time();
    }


    public function testAdd(): void
    {
        $operand    = 12;
        $expexted   = $this->time + $operand;
        $this->assertSame($expexted, $this->calculator->add($this->time, $operand));
    }


    public function testDivide(): void
    {
        $operand    = 12;
        $expexted   = $this->time / $operand;
        $this->assertSame($expexted, $this->calculator->divide($this->time, $operand));
    }


    public function testGetAbsoluteTime(): void
    {
        $time = $this->time * -1;
        $this->assertSame($this->time, $this->calculator->getAbsoluteTime($time));
    }


    public function testMultiply(): void
    {
        $operand    = 12;
        $expexted   = $this->time * $operand;
        $this->assertSame($expexted, $this->calculator->multiply($this->time, $operand));
    }


    public function testModulo(): void
    {
        $operand    = 12;
        $expexted   = $this->time % $operand;
        $this->assertSame($expexted, $this->calculator->modulo($this->time, $operand));
    }


    public function testSubtract(): void
    {
        $operand    = 12;
        $expexted   = $this->time - $operand;
        $this->assertSame($expexted, $this->calculator->subtract($this->time, $operand));
    }
}
