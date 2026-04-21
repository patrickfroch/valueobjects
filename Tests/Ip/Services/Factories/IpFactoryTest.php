<?php

/**
 * @since       09.08.2022 - 14:08
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Ip\Services\Factories;

use Esit\Valueobjects\Classes\Ip\Services\Factories\IpFactory;
use Esit\Valueobjects\Classes\Ip\Services\Validators\IpValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IpFactoryTest extends TestCase
{

    /**
     * @var IpValidator&MockObject
     */
    private IpValidator $validator;


    /**
     * @var IpFactory
     */
    private IpFactory $factory;


    protected function setUp(): void
    {
        $this->validator    = $this->getMockBuilder(IpValidator::class)->disableOriginalConstructor()->getMock();
        $this->factory      = new IpFactory($this->validator);
    }


    public function testCreateIpFromStringReturnObject(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('127.0.0.1')->willReturn(true);
        $this->assertNotNull($this->factory->createFromString('127.0.0.1'));
    }
}
