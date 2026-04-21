<?php

/**
 * @since       09.08.2022 - 14:13
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Ip\Valueobjects;

use Esit\Valueobjects\Classes\Ip\Exceptions\NotAValidIpException;
use Esit\Valueobjects\Classes\Ip\Services\Validators\IpValidator;
use Esit\Valueobjects\Classes\Ip\Valueobjects\IpValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IpValueTest extends TestCase
{

    /**
     * @var IpValidator&MockObject
     */
    private IpValidator $validator;

    protected function setUp(): void
    {
        $this->validator = $this->getMockBuilder(IpValidator::class)->disableOriginalConstructor()->getMock();
    }


    public function testFromStringThrowExceptionIfIpIsNotValid(): void
    {
        $this->expectException(NotAValidIpException::class);
        $this->expectExceptionMessage('string is not a valid ip address');
        $this->validator->expects($this->once())->method('isValid')->with('512.0.0.1')->willReturn(false);
        IpValue::fromString('512.0.0.1', $this->validator);
    }


    public function testFromStringReturnObjectIfIpIsValid(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('127.0.0.1')->willReturn(true);
        $this->assertNotNull(IpValue::fromString('127.0.0.1', $this->validator));
    }


    public function testValueReturnValue(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('127.0.0.1')->willReturn(true);
        $ip = IpValue::fromString('127.0.0.1', $this->validator);
        $this->assertSame('127.0.0.1', $ip->value());
    }

    public function testToStringReturnValue(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('127.0.0.1')->willReturn(true);
        $ip = IpValue::fromString('127.0.0.1', $this->validator);
        $this->assertSame('127.0.0.1', (string) $ip);
    }
}
