<?php

/**
 * @since       08.09.2024 - 16:57
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Database\Services\Validators;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Esit\Valueobjects\Classes\Database\Services\Factories\SchemaManagerFactory;
use Esit\Valueobjects\Classes\Database\Services\Validators\FieldnameValidator;
use Esit\Valueobjects\Classes\Database\Valueobjects\TablenameValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FieldnameValidatorTest extends TestCase
{


    /**
     * @var (SchemaManagerFactory&MockObject)|MockObject
     */
    private $schemeManagerFactory;


    /**
     * @var (AbstractSchemaManager&MockObject)|MockObject
     */
    private $schemeManager;


    /**
     * @var (TablenameValue&MockObject)|MockObject
     */
    private $tablename;


    private $column;


    /**
     * @var FieldnameValidator
     */
    private FieldnameValidator $validator;


    protected function setUp(): void
    {
        $this->schemeManagerFactory = $this->getMockBuilder(SchemaManagerFactory::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->schemeManager        = $this->getMockBuilder(AbstractSchemaManager::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->tablename            = $this->getMockBuilder(TablenameValue::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->column               = $this->getMockBuilder(Column::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->schemeManagerFactory->method('getSchemaManager')
                                   ->willReturn($this->schemeManager);

        $this->tablename->method('value')
                        ->willReturn('tl_table');

        $this->validator        = new FieldnameValidator($this->schemeManagerFactory);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testValidateReturnFalseIfNameIsNotFount(): void
    {
        $fieldname   = 'example_field';
        $fields      = [$this->column, $this->column];

        $this->schemeManager->expects($this->once())
                            ->method('listTableColumns')
                            ->with('tl_table')
                            ->willReturn($fields);

        $this->column->expects($this->exactly(\count($fields)))
                     ->method('getName')
                     ->willReturnOnConsecutiveCalls(
                         'test_field',
                         'my_test_field'
                     );

        $this->assertFalse($this->validator->validate($fieldname, $this->tablename));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testValidateReturnTrueIfNameIsFount(): void
    {
        $fieldname   = 'example_field';
        $fields      = [$this->column, $this->column];

        $this->schemeManager->expects($this->once())
                            ->method('listTableColumns')
                            ->with('tl_table')
                            ->willReturn($fields);

        $this->column->expects($this->exactly(\count($fields)))
                     ->method('getName')
                     ->willReturnOnConsecutiveCalls(
                         'test_field',
                         'example_field'
                     );

        $this->assertTrue($this->validator->validate($fieldname, $this->tablename));
    }
}
