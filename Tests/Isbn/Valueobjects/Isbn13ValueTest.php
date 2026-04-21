<?php

/**
 * @since       06.08.2022 - 13:08
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
use Esit\Valueobjects\Classes\Isbn\Valueobjects\Isbn13Value;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class Isbn13ValueTest extends TestCase
{

    /**
     * @var IsbnValidator&MockObject
     */
    private IsbnValidator $validator;


    /**
     * @var string
     */
    private $value = '978-3827330147';


    protected function setUp(): void
    {
        $this->validator = $this->getMockBuilder(IsbnValidator::class)->disableOriginalConstructor()->getMock();
    }


    public function testFromStringReturnObjectIfValueIsValid(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn13')->with($this->value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum13')->with($this->value)->willReturn(true);
        $this->assertNotNull(Isbn13Value::fromString($this->value, $this->validator));
    }


    public function testFromStringThrowExceptionIfValueIsNoIsbn13(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn13')->with($this->value)->willReturn(false);
        $this->validator->expects($this->never())->method('validateCheckSum13');
        $this->expectException(NotAValidIsbnStringException::class);
        $this->expectExceptionMessage('string is no valid isbn13');
        Isbn13Value::fromString($this->value, $this->validator);
    }


    public function testFromStringReturnObjectIfChecksumIsWrond(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn13')->with($this->value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum13')->with($this->value)->willReturn(false);
        $this->expectException(NotAValidIsbnStringException::class);
        $this->expectExceptionMessage('string is no valid isbn13');
        $this->assertNotNull(Isbn13Value::fromString($this->value, $this->validator));
    }


    public function testValueReturnValue(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn13')->with($this->value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum13')->with($this->value)->willReturn(true);
        $isbn = Isbn13Value::fromString($this->value, $this->validator);
        $this->assertSame($this->value, $isbn->value());
    }


    public function testToStringReturnValue(): void
    {
        $this->validator->expects($this->once())->method('isValidIsbn13')->with($this->value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum13')->with($this->value)->willReturn(true);
        $isbn = Isbn13Value::fromString($this->value, $this->validator);
        $this->assertSame($this->value, (string) $isbn);
    }
}
