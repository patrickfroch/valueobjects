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

namespace Esit\Valueobjects\Tests\Database\Valueobjects;

use Esit\Valueobjects\Classes\Database\Exceptions\NotAValidFieldnameException;
use Esit\Valueobjects\Classes\Database\Services\Validators\FieldnameValidator;
use Esit\Valueobjects\Classes\Database\Valueobjects\FieldnameValue;
use Esit\Valueobjects\Classes\Database\Valueobjects\TablenameValue;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[AllowMockObjectsWithoutExpectations]
class FieldnameValueTest extends TestCase
{


    /**
     * @var (FieldnameValidator&MockObject)|MockObject
     */
    private $validator;


    /**
     * @var (FieldnameValue&MockObject)|MockObject
     */
    private $tablename;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->validator    = $this->getMockBuilder(FieldnameValidator::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->tablename    = $this->getMockBuilder(TablenameValue::class)
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
        $value = 'valid_fieldname';

        $this->validator->expects($this->once())
                        ->method('validate')
                        ->with($value)
                        ->willReturn(true);

        $name = FieldnameValue::fromString($value, $this->tablename, $this->validator);
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
                        ->with($value, $this->tablename)
                        ->willReturn(false);

        $this->expectException(NotAValidFieldnameException::class);
        $this->expectExceptionMessage('string is no valid field name: ' . $value);

        FieldnameValue::fromString($value, $this->tablename, $this->validator);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFromStringReturnDatabasenameValueIfValueIsValid(): void
    {
        $value = 'valid_databasename';

        $this->validator->expects($this->once())
                        ->method('validate')
                        ->with($value, $this->tablename)
                        ->willReturn(true);

        $name = FieldnameValue::fromString($value, $this->tablename, $this->validator);
        $this->assertNotNull($name);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testValue(): void
    {
        $value = 'valid_databasename';

        $this->validator->expects($this->once())
                        ->method('validate')
                        ->with($value, $this->tablename)
                        ->willReturn(true);

        $name = FieldnameValue::fromString($value, $this->tablename, $this->validator);

        $this->assertSame($value, $name->value());
    }
}
