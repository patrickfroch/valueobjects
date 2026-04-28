<?php

/**
 * @since       11.03.2024 - 15:03
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Duration\Services\Factories;

use Esit\Valueobjects\Classes\Duration\Services\Calculators\DurationCalculator;
use Esit\Valueobjects\Classes\Duration\Services\Factories\DurationFactory;
use Esit\Valueobjects\Classes\Duration\Services\Parser\DurationParser;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[AllowMockObjectsWithoutExpectations]
class DurationFactoryTest extends TestCase
{


    /**
     * @var (DurationCalculator&MockObject)|MockObject
     */
    private $calculator;


    /**
     * @var (DurationParser&MockObject)|MockObject
     */
    private $converter;


    /**
     * @var DurationFactory
     */
    private DurationFactory $factory;


    /**
     * @var int
     */
    private int $time = 0;


    protected function setUp(): void
    {
        $this->calculator   = $this->getMockBuilder(DurationCalculator::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->converter    = $this->getMockBuilder(DurationParser::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->time         = \time();

        $this->factory      = new DurationFactory($this->calculator, $this->converter);
    }


    public function testCreateDuration(): void
    {
        $this->assertNotNull($this->factory->createDurationFromInt($this->time));
    }
}
