<?php

/**
 * @since       08.08.2022 - 14:10
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Url\Valueobjects;

use Esit\Valueobjects\Classes\Url\Exceptions\NotAValidUrlException;
use Esit\Valueobjects\Classes\Url\Services\Validators\UrlValidator;
use Esit\Valueobjects\Classes\Url\Valueobjects\UrlValue;
use PHPUnit\Framework\TestCase;

class UrlValueTest extends TestCase
{

    private UrlValidator $validator;

    protected function setUp(): void
    {
        $this->validator = $this->getMockBuilder(UrlValidator::class)->disableOriginalConstructor()->getMock();
    }


    public function testFromStringThrowExceptionIfUrlIsNotValid(): void
    {
        $this->expectException(NotAValidUrlException::class);
        $this->expectExceptionMessage('string is not a valid url');
        $this->validator->expects($this->once())->method('isValid')->with('-htps:/-example')->willReturn(false);
        UrlValue::fromString('-htps:/-example', $this->validator);
    }


    public function testFromStringReturnObjectIfUrlIsValid(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('example.com')->willReturn(true);
        $this->assertNotNull(UrlValue::fromString('example.com', $this->validator));
    }


    public function testFromStringReturnObjectIfUrlIsValidWithForceSchema(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('https://example.com')->willReturn(true);
        $this->assertNotNull(UrlValue::fromString('https://example.com', $this->validator, true));
    }


    public function testFromStringReturnObjectIfUrlIsValidAndIndividualSchemaiIsSet(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('dav://example.com')->willReturn(true);
        $this->assertNotNull(UrlValue::fromString('dav://example.com', $this->validator, true, 'dav'));
    }


    public function testValueReturnValue(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('https://example.com')->willReturn(true);
        $url = UrlValue::fromString('https://example.com', $this->validator);
        $this->assertSame('https://example.com', $url->value());
    }


    public function testToStringReturnValue(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('https://example.com')->willReturn(true);
        $url = UrlValue::fromString('https://example.com', $this->validator);
        $this->assertSame('https://example.com', (string) $url);
    }
}
