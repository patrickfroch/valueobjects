<?php

/**
 * @since       06.08.2022 - 10:08
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Isbn\Valueobjects;

use Esit\Valueobjects\Classes\Isbn\Exceptions\NotAValidIsbnStringException;
use Esit\Valueobjects\Classes\Isbn\Services\Validators\IsbnValidator;
use Esit\Valueobjects\Classes\Isbn\Valueobjects\Isbn10Value;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class Isbn10ValueTest extends TestCase
{

    /**
     * @var IsbnValidator&MockObject
     */
    private IsbnValidator $validator;


    /**
     * @var string
     */
    private $value = '3827330149';

    protected function setUp(): void
    {
        $this->validator = $this->getMockBuilder(IsbnValidator::class)->disableOriginalConstructor()->getMock();
    }


    public function testFromStringReturnObjectIfValueIsValid(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn10')->with($this->value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum10')->with($this->value)->willReturn(true);
        $this->assertNotNull(Isbn10Value::fromString($this->value, $this->validator));
    }


    public function testFromStringThrowExceptionIfValueIsNoIsbn10(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn10')->with($this->value)->willReturn(false);
        $this->validator->expects($this->never())->method('validateCheckSum10');
        $this->expectException(NotAValidIsbnStringException::class);
        $this->expectExceptionMessage('string is no valid isbn10');
        Isbn10Value::fromString($this->value, $this->validator);
    }


    public function testFromStringReturnObjectIfChecksumIsWrond(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn10')->with($this->value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum10')->with($this->value)->willReturn(false);
        $this->expectException(NotAValidIsbnStringException::class);
        $this->expectExceptionMessage('string is no valid isbn10');
        $this->assertNotNull(Isbn10Value::fromString($this->value, $this->validator));
    }


    public function testValueReturnValue(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn10')->with($this->value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum10')->with($this->value)->willReturn(true);
        $isbn = Isbn10Value::fromString($this->value, $this->validator);
        $this->assertSame($this->value, $isbn->value());
    }


    public function testToStringReturnValue(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn10')->with($this->value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum10')->with($this->value)->willReturn(true);
        $isbn = Isbn10Value::fromString($this->value, $this->validator);
        $this->assertSame($this->value, (string) $isbn);
    }
}
