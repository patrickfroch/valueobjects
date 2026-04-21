<?php

/**
 * @version     1.0.0
 *
 * @since       19.09.22 - 13:23
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tetsts\Iban\Services\Factories;

use Esit\Valueobjects\Classes\Iban\Services\Converter\IbanConverter;
use Esit\Valueobjects\Classes\Iban\Services\Factories\IbanFactory;
use Esit\Valueobjects\Classes\Iban\Services\Validators\IbanValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IbanFactoryTest extends TestCase
{


    /**
     * @var IbanConverter&MockObject|MockObject
     */
    private $converter;


    /**
     * @var IbanValidator&MockObject|MockObject
     */
    private $validator;


    /**
     * @var IbanFactory
     */
    private IbanFactory $factory;


    protected function setUp(): void
    {
        $this->converter = $this->getMockBuilder(IbanConverter::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->validator = $this->getMockBuilder(IbanValidator::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->factory = new IbanFactory($this->converter, $this->validator);
    }


    public function testCreateFromString(): void
    {
        $iban = 'DE79345678901234567890';

        $this->converter->expects($this->once())
                        ->method('convertToIban')
                        ->with($iban)
                        ->willReturn($iban);

        $this->validator->expects($this->once())
                        ->method('isValid')
                        ->with($iban)
                        ->willReturn(true);

        $this->validator->expects($this->once())
                        ->method('isValidChecksum')
                        ->with($iban)
                        ->willReturn(true);

        $this->assertNotNull($this->factory->createFromString($iban));
    }
}
