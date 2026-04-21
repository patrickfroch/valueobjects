<?php

/**
 * @since       08.08.2022 - 16:03
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Email\Valueobjects;

use Esit\Valueobjects\Classes\Email\Exceptions\NotAValidEmailException;
use Esit\Valueobjects\Classes\Email\Services\Validators\EmailValidator;
use Esit\Valueobjects\Classes\Email\Valuobjects\EmailValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EmailValueTest extends TestCase
{


    /**
     * @var EmailValidator&MockObject
     */
    private EmailValidator $validator;

    protected function setUp(): void
    {
        $this->validator = $this->getMockBuilder(EmailValidator::class)->disableOriginalConstructor()->getMock();
    }


    public function testFromStringReturnObjectIfEmailIsValid(): void
    {
        $mail = 'info@example.org';
        $this->validator->expects($this->once())->method('isValid')->with($mail)->willReturn(true);
        $email = EmailValue::fromString($mail, $this->validator);
        $this->assertNotNull($email);
    }


    public function testFromStringThrowExceptionIfEmailIsNotValid(): void
    {
        $mail = 'info@example.org-';
        $this->validator->expects($this->once())->method('isValid')->with($mail)->willReturn(false);
        $this->expectException(NotAValidEmailException::class);
        $this->expectExceptionMessage('string is not a valid email');
        EmailValue::fromString($mail, $this->validator);
    }


    public function testValueReturnValue(): void
    {
        $mail = 'info@example.org';
        $this->validator->expects($this->once())->method('isValid')->with($mail)->willReturn(true);
        $email = EmailValue::fromString($mail, $this->validator);
        $this->assertSame($mail, $email->value());
    }


    public function testToStringReturnValue(): void
    {
        $mail = 'info@example.org';
        $this->validator->expects($this->once())->method('isValid')->with($mail)->willReturn(true);
        $email = EmailValue::fromString($mail, $this->validator);
        $this->assertSame($mail, (string) $email);
    }
}
