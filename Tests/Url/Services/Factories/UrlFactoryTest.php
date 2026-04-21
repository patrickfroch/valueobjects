<?php

/**
 * @since       08.08.2022 - 14:06
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Url\Services\Factories;

use Esit\Valueobjects\Classes\Url\Services\Factories\UrlFactory;
use Esit\Valueobjects\Classes\Url\Services\Validators\UrlValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UrlFactoryTest extends TestCase
{


    /**
     * @var UrlValidator&MockObject
     */
    private UrlValidator $validator;


    /**
     * @var UrlFactory
     */
    private UrlFactory $factory;


    protected function setUp(): void
    {
        $this->validator    = $this->getMockBuilder(UrlValidator::class)->disableOriginalConstructor()->getMock();
        $this->factory      = new UrlFactory($this->validator);
    }


    public function testCreateUrlFromString(): void
    {
        $this->validator->expects($this->once())->method('isValid')->with('dav://example.org/')->willReturn(true);

        $this->assertNotNull($this->factory->createFromString('dav://example.org/', true, 'dav'));
    }
}
