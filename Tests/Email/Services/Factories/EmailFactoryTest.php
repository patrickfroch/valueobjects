<?php

/**
 * @since       08.08.2022 - 15:58
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Email\Services\Factories;

use Esit\Valueobjects\Classes\Email\Services\Factories\EmailFactory;
use Esit\Valueobjects\Classes\Email\Services\Validators\EmailValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EmailFactoryTest extends TestCase
{


    /**
     * @var EmailValidator&MockObject
     */
    private EmailValidator $validator;


    /**
     * @var EmailFactory
     */
    private EmailFactory $factory;


    protected function setUp(): void
    {
        $this->validator    = $this->getMockBuilder(EmailValidator::class)->disableOriginalConstructor()->getMock();
        $this->factory      = new EmailFactory($this->validator);
    }


    public function testCreateEmailFromStringReturnObject(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('info@example.org')->willReturn(true);
        $this->assertNotNull($this->factory->createFromString('info@example.org'));
    }
}
