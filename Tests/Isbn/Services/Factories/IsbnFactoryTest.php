<?php

/**
 * @since       06.08.2022 - 13:00
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Isbn\Services\Factories;

use Esit\Valueobjects\Classes\Isbn\Services\Factories\IsbnFactory;
use Esit\Valueobjects\Classes\Isbn\Services\Validators\IsbnValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IsbnFactoryTest extends TestCase
{

    /**
     * @var IsbnValidator&MockObject
     */
    private IsbnValidator $validator;


    /**
     * @var IsbnFactory
     */
    private IsbnFactory $factory;

    protected function setUp(): void
    {
        $this->validator    = $this->getMockBuilder(IsbnValidator::class)->disableOriginalConstructor()->getMock();
        $this->factory      = new IsbnFactory($this->validator);
    }


    public function testCreateIsbn10FromStringReturnObject(): void
    {
        $value = '3827330149';
        $this->validator->expects($this->once())->method('isValidIsbn10')->with($value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum10')->with($value)->willReturn(true);
        $this->assertNotNull($this->factory->createIsbn10FromString($value));
    }


    public function testCreateIsbn13FromStringReturnObject(): void
    {
        $value = '978-3827330147';
        $this->validator->expects($this->once())->method('isValidIsbn13')->with($value)->willReturn(true);
        $this->validator->expects($this->once())->method('validateCheckSum13')->with($value)->willReturn(true);
        $this->assertNotNull($this->factory->createIsbn13FromString($value));
    }
}
