<?php

/**
 * @since       08.09.2024 - 17:45
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Database\Services\Factories;

use Esit\Valueobjects\Classes\Database\Enums\DatabasenamesInterface;
use Esit\Valueobjects\Classes\Database\Enums\FieldnamesInterface;
use Esit\Valueobjects\Classes\Database\Enums\TablenamesInterface;
use Esit\Valueobjects\Classes\Database\Services\Factories\DatabasenameFactory;
use Esit\Valueobjects\Classes\Database\Services\Validators\DatabasenameValidator;
use Esit\Valueobjects\Classes\Database\Services\Validators\FieldnameValidator;
use Esit\Valueobjects\Classes\Database\Services\Validators\TablenameValidator;
use Esit\Valueobjects\Classes\Database\Valueobjects\TablenameValue;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

enum TestDatabase implements DatabasenamesInterface
{
    case test;
}
enum TestTable implements TablenamesInterface
{
    case test;
}
enum TestField implements FieldnamesInterface
{
    case test;
}

#[AllowMockObjectsWithoutExpectations]
class DatabasenameFactoryTest extends TestCase
{

    /**
     * @var (DatabasenameValidator&MockObject)|MockObject
     */
    private $databasenameValidator;


    /**
     * @var (FieldnameValidator&MockObject)|MockObject
     */
    private $fieldnameValidator;


    /**
     * @var (TablenameValidator&MockObject)|MockObject
     */
    private $tablenameValidator;

    /**
     * @var (TablenameValue&MockObject)|MockObject
     */
    private $tablenameValue;


    /**
     * @var DatabasenameFactory
     */
    private DatabasenameFactory $factory;


    protected function setUp(): void
    {
        $this->databasenameValidator = $this->getMockBuilder(DatabasenameValidator::class)
                                            ->disableOriginalConstructor()
                                            ->getMock();

        $this->fieldnameValidator   = $this->getMockBuilder(FieldnameValidator::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->tablenameValidator   = $this->getMockBuilder(TablenameValidator::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->tablenameValue       = $this->getMockBuilder(TablenameValue::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->factory              = new DatabasenameFactory(
            $this->databasenameValidator,
            $this->fieldnameValidator,
            $this->tablenameValidator);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateDatabasenameFromString(): void
    {
        $this->databasenameValidator->expects($this->once())
                                    ->method('validate')
                                    ->willReturn(true);

        $this->assertNotNull($this->factory->createDatabasenameFromString('exampleDatabase'));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateDatabasenameFromInterface(): void
    {
        $this->databasenameValidator->expects($this->once())
                                    ->method('validate')
                                    ->willReturn(true);

        $this->assertNotNull($this->factory->createDatabasenameFromInterface(TestDatabase::test));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateFieldnameFromStringWithString(): void
    {
        $tablename = 'tl_example';

        $this->tablenameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->fieldnameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->assertNotNull($this->factory->createFieldnameFromString('testfield', $tablename));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateFieldnameFromStringWithTablenaemValue(): void
    {
        $this->tablenameValidator->expects($this->never())
                                 ->method('validate');

        $this->fieldnameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->assertNotNull($this->factory->createFieldnameFromString('testfield', $this->tablenameValue));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateFieldnameFromInterfaceWithTablenameInterface(): void
    {
        $this->tablenameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->fieldnameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->assertNotNull($this->factory->createFieldnameFromInterface(TestField::test, TestTable::test));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateFieldnameFromInterfaceWithTablenameValue(): void
    {
        $this->tablenameValidator->expects($this->never())
                                 ->method('validate');

        $this->fieldnameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->assertNotNull($this->factory->createFieldnameFromInterface(TestField::test, $this->tablenameValue));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateFieldnameFromStringOrInterfaceCreateFromInterface(): void
    {
        $this->tablenameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->fieldnameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $rtn = $this->factory->createFieldnameFromStringOrInterface(TestField::test, TestTable::test);

        $this->assertNotNull($rtn);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateFieldnameFromStringOrInterfaceCreateFromString(): void
    {
        $this->tablenameValidator->expects($this->never())
                                 ->method('validate');

        $this->fieldnameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $rtn = $this->factory->createFieldnameFromStringOrInterface(TestField::test->name, $this->tablenameValue);

        $this->assertNotNull($rtn);
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateTablenameFromString(): void
    {
        $this->tablenameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->assertNotNull($this->factory->createTablenameFromString('tl_example'));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateTablenameFromInterface(): void
    {
        $this->tablenameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->assertNotNull($this->factory->createTablenameFromInterface(TestTable::test));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateTablenameFromStringOrInterfaceCreateFromInterface(): void
    {
        $this->tablenameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->assertNotNull($this->factory->createTablenameFromStringOrInterface(TestTable::test));
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testCreateTablenameFromStringOrInterfaceCreateFromString(): void
    {
        $this->tablenameValidator->expects($this->once())
                                 ->method('validate')
                                 ->willReturn(true);

        $this->assertNotNull($this->factory->createTablenameFromStringOrInterface(TestTable::test->name));
    }
}
