<?php

declare(strict_types=1);

/**
 * @version     1.0.0
 *
 * @since       19.09.22 - 13:51
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

namespace Esit\Valueobjects\Tests\Iban\Valueobjects;

use Esit\Valueobjects\Classes\Iban\Exceptions\NotAValidIbanException;
use Esit\Valueobjects\Classes\Iban\Services\Converter\IbanConverter;
use Esit\Valueobjects\Classes\Iban\Services\Validators\IbanValidator;
use Esit\Valueobjects\Classes\Iban\Valueobjects\IbanValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IbanValueTest extends TestCase
{


    /**
     * @var IbanConverter&MockObject|MockObject
     */
    private $converter;


    /**
     * @var IbanValidator&MockObject|MockObject
     */
    private $validator;


    protected function setUp(): void
    {
        $this->converter = $this->getMockBuilder(IbanConverter::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->validator = $this->getMockBuilder(IbanValidator::class)
                                ->disableOriginalConstructor()
                                ->getMock();
    }


    public function testFromStringThrowExceptionIfIbanIsEmpty(): void
    {
        $this->expectException(NotAValidIbanException::class);
        $this->expectExceptionMessage('iban could not be empty');
        IbanValue::fromString('', $this->converter, $this->validator);
    }


    public function testFromStringThrowExceptionIfIbanIsNotValid(): void
    {
        $iban   = 'DE79 3456 7890 1234 5678 90';
        $clean  = 'DE79345678901234567890';

        $this->converter->expects($this->once())
                        ->method('convertToIban')
                        ->with($iban)
                        ->willReturn($clean);

        $this->validator->expects($this->once())
                        ->method('isValid')
                        ->with($clean)
                        ->willReturn(false);

        $this->expectException(NotAValidIbanException::class);
        $this->expectExceptionMessage('string is no valid iban');
        IbanValue::fromString($iban, $this->converter, $this->validator);
    }


    public function testFromStringThrowExceptionIfChecksumIsNotValid(): void
    {
        $iban   = 'DE12 3456 7890 1234 5678 90';
        $clean  = 'DE12345678901234567890';

        $this->converter->expects($this->once())
                        ->method('convertToIban')
                        ->with($iban)
                        ->willReturn($clean);

        $this->validator->expects($this->once())
                        ->method('isValid')
                        ->with($clean)
                        ->willReturn(true);

        $this->validator->expects($this->once())
                        ->method('isValidChecksum')
                        ->with($clean)
                        ->willReturn(false);

        $this->expectException(NotAValidIbanException::class);
        $this->expectExceptionMessage('checksum is not valid');
        IbanValue::fromString($iban, $this->converter, $this->validator);
    }


    public function testFromStringReturnValueObjectIfIbanIsValid(): void
    {
        $iban   = 'DE79 3456 7890 1234 5678 90';
        $clean  = 'DE79345678901234567890';

        $this->converter->expects($this->once())
                        ->method('convertToIban')
                        ->with($iban)
                        ->willReturn($clean);

        $this->validator->expects($this->once())
                        ->method('isValid')
                        ->with($clean)
                        ->willReturn(true);

        $this->validator->expects($this->once())
                        ->method('isValidChecksum')
                        ->with($clean)
                        ->willReturn(true);

        $this->assertNotNull(IbanValue::fromString($iban, $this->converter, $this->validator));
    }


    public function testValueReturnIbanWithoutSpaces(): void
    {
        $iban   = 'DE79 3456 7890 1234 5678 90';
        $clean  = 'DE79345678901234567890';

        $this->converter->expects($this->once())
                        ->method('convertToIban')
                        ->with($iban)
                        ->willReturn($clean);

        $this->validator->expects($this->once())
                        ->method('isValid')
                        ->with($clean)
                        ->willReturn(true);

        $this->validator->expects($this->once())
                        ->method('isValidChecksum')
                        ->with($clean)
                        ->willReturn(true);

        $value = IbanValue::fromString($iban, $this->converter, $this->validator);
        $this->assertSame($clean, $value->value());
    }


    public function testToStringIbanWithoutSpaces(): void
    {
        $iban   = 'DE79 3456 7890 1234 5678 90';
        $clean  = 'DE79345678901234567890';

        $this->converter->expects($this->once())
                        ->method('convertToIban')
                        ->with($iban)
                        ->willReturn($clean);

        $this->validator->expects($this->once())
                        ->method('isValid')
                        ->with($clean)
                        ->willReturn(true);

        $this->validator->expects($this->once())
                        ->method('isValidChecksum')
                        ->with($clean)
                        ->willReturn(true);

        $value = IbanValue::fromString($iban, $this->converter, $this->validator);
        $this->assertSame($clean, (string) $value);
    }


    public function testGetFormatedValueReturnIbanWithSpaces(): void
    {
        $iban   = 'DE79 3456 7890 1234 5678 90';
        $clean  = 'DE79345678901234567890';

        $this->converter->expects($this->once())
                        ->method('convertToIban')
                        ->with($clean)
                        ->willReturn($clean);

        $this->converter->expects($this->once())
                        ->method('convertToFormated')
                        ->with($clean)
                        ->willReturn($iban);

        $this->validator->expects($this->once())
                        ->method('isValid')
                        ->with($clean)
                        ->willReturn(true);

        $this->validator->expects($this->once())
                        ->method('isValidChecksum')
                        ->with($clean)
                        ->willReturn(true);

        $value = IbanValue::fromString($clean, $this->converter, $this->validator);
        $this->assertSame($iban, $value->getFormatedValue());
    }
}
