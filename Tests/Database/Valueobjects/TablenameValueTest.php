<?php

/**
 * @since       08.09.2024 - 09:32
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Database\Valueobjects;

use Esit\Valueobjects\Classes\Database\Exceptions\NotAValidTablenameException;
use Esit\Valueobjects\Classes\Database\Services\Validators\TablenameValidator;
use Esit\Valueobjects\Classes\Database\Valueobjects\TablenameValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TablenameValueTest extends TestCase
{


    /**
     * @var (TablenameValidator&MockObject)|MockObject
     */
    private $validator;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->validator = $this->getMockBuilder(TablenameValidator::class)
                                ->disableOriginalConstructor()
                                ->getMock();
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testToString(): void
    {
        $value = 'valid_tablename';

        $this->validator->expects($this->once())
                        ->method('validate')
                        ->with($value)
                        ->willReturn(true);

        $name = TablenameValue::fromString($value, $this->validator);
        $this->assertSame($value, (string) $name);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFromStringThrowExceptionIfValueIsNotValid(): void
    {
        $value = 'not_valid_databasename';

        $this->validator->expects($this->once())
                        ->method('validate')
                        ->with($value)
                        ->willReturn(false);

        $this->expectException(NotAValidTablenameException::class);
        $this->expectExceptionMessage('string is no valid table name: ' . $value);

        TablenameValue::fromString($value, $this->validator);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFromStringReturnDatabasenameValueIfValueIsValid(): void
    {
        $value = 'valid_tablename';

        $this->validator->expects($this->once())
                        ->method('validate')
                        ->with($value)
                        ->willReturn(true);

        $name = TablenameValue::fromString($value, $this->validator);
        $this->assertNotNull($name);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testValue(): void
    {
        $value = 'valid_tablename';

        $this->validator->expects($this->once())
                        ->method('validate')
                        ->with($value)
                        ->willReturn(true);

        $name = TablenameValue::fromString($value, $this->validator);

        $this->assertSame($value, $name->value());
    }
}
