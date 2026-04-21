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

namespace Esit\Valueobjects\Tests\Database\Services\Validators;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Esit\Valueobjects\Classes\Database\Services\Factories\SchemaManagerFactory;
use Esit\Valueobjects\Classes\Database\Services\Validators\DatabasenameValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DatabasenameValidatorTest extends TestCase
{


    /**
     * @var (SchemaManagerFactory&MockObject)|MockObject
     */
    private $schemaManagerFactroy;


    /**
     * @var (AbstractSchemaManager&MockObject)|MockObject
     */
    private $schemeManager;


    /**
     * @var DatabasenameValidator
     */
    private DatabasenameValidator $validator;


    protected function setUp(): void
    {
        $this->schemaManagerFactroy = $this->getMockBuilder(SchemaManagerFactory::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->schemeManager        = $this->getMockBuilder(AbstractSchemaManager::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->schemaManagerFactroy->method('getSchemaManager')
                                   ->willReturn($this->schemeManager);

        $this->validator            = new DatabasenameValidator($this->schemaManagerFactroy);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testValidateReturnFalseIfNameIsNotFount(): void
    {
        $databasename   = 'example_databasename';
        $databases      = ['test_database', 'my_test_databasename'];

        $this->schemeManager->expects($this->once())
                            ->method('listDatabases')
                            ->willReturn($databases);

        $this->assertFalse($this->validator->validate($databasename));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testValidateReturnTrueIfNameIsFount(): void
    {
        $databasename   = 'example_databasename';
        $databases      = ['test_database', 'my_test_databasename', 'example_databasename'];

        $this->schemeManager->expects($this->once())
                            ->method('listDatabases')
                            ->willReturn($databases);

        $this->assertTrue($this->validator->validate($databasename));
    }
}
