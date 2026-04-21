<?php

/**
 * @since       07.09.2024 - 11:44
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Database\Services\Factories;

use Doctrine\DBAL\Exception;
use Esit\Valueobjects\Classes\Database\Enums\DatabasenamesInterface;
use Esit\Valueobjects\Classes\Database\Enums\FieldnamesInterface;
use Esit\Valueobjects\Classes\Database\Enums\TablenamesInterface;
use Esit\Valueobjects\Classes\Database\Services\Validators\DatabasenameValidator;
use Esit\Valueobjects\Classes\Database\Services\Validators\FieldnameValidator;
use Esit\Valueobjects\Classes\Database\Services\Validators\TablenameValidator;
use Esit\Valueobjects\Classes\Database\Valueobjects\DatabasenameValue;
use Esit\Valueobjects\Classes\Database\Valueobjects\FieldnameValue;
use Esit\Valueobjects\Classes\Database\Valueobjects\TablenameValue;

class DatabasenameFactory
{


    /**
     * @param DatabasenameValidator $databasenameValidator
     * @param FieldnameValidator    $fieldnameValidator
     * @param TablenameValidator    $tablenameValidator
     */
    public function __construct(
        private readonly DatabasenameValidator $databasenameValidator,
        private readonly FieldnameValidator $fieldnameValidator,
        private readonly TablenameValidator $tablenameValidator
    ) {
    }


    /**
     * Erstellt ein DatabasenameValue aus einem String.
     *
     * @param string $databasename
     *
     * @return DatabasenameValue
     *
     * @throws Exception
     *
     * @deprecated  use $this->createDatabasenameFromNameInterface() instead
     */
    public function createDatabasenameFromString(string $databasename): DatabasenameValue
    {
        return DatabasenameValue::fromString($databasename, $this->databasenameValidator);
    }


    /**
     * Erstellt ein DatabasenameValue aus einem NameInterface.
     *
     * @param DatabasenamesInterface $databasename
     *
     * @return DatabasenameValue
     *
     * @throws Exception
     */
    public function createDatabasenameFromInterface(DatabasenamesInterface $databasename): DatabasenameValue
    {
        return DatabasenameValue::fromInterface($databasename, $this->databasenameValidator);
    }


    /**
     * Erstellt ein FieldnameValue aus einem String.
     *
     * @param string                $fieldname
     * @param string|TablenameValue $tablename
     *
     * @return FieldnameValue
     *
     * @throws Exception
     */
    public function createFieldnameFromString(string $fieldname, string|TablenameValue $tablename): FieldnameValue
    {
        if (true === \is_string($tablename)) {
            $tablename = $this->createTablenameFromString($tablename);
        }

        return FieldnameValue::fromString($fieldname, $tablename, $this->fieldnameValidator);
    }


    /**
     * Erstellt ein FieldnameValue aus einem FieldnameInterface.
     *
     * @param FieldnamesInterface                $fieldname
     * @param TablenamesInterface|TablenameValue $tablename
     *
     * @return FieldnameValue
     *
     * @throws Exception
     */
    public function createFieldnameFromInterface(
        FieldnamesInterface $fieldname,
        TablenamesInterface|TablenameValue $tablename
    ): FieldnameValue {
        if ($tablename instanceof TablenamesInterface) {
            $tablename = $this->createTablenameFromInterface($tablename);
        }

        return FieldnameValue::fromInterface($fieldname, $tablename, $this->fieldnameValidator);
    }


    /**
     * Erestellt ein FieldnameValue aus einem String oder einem TablenamesInterface.
     * (Fasssade für $this->createTablenameFromString() und $this->createTablenameFromInterface())
     *
     * @param FieldnamesInterface|string         $fieldname
     * @param TablenamesInterface|TablenameValue $tablename
     *
     * @return FieldnameValue
     *
     * @throws Exception
     */
    public function createFieldnameFromStringOrInterface(
        FieldnamesInterface|string $fieldname,
        TablenamesInterface|TablenameValue $tablename
    ): FieldnameValue {
        if ($tablename instanceof TablenamesInterface) {
            $tablename = $this->createTablenameFromInterface($tablename);
        }

        if (true === \is_string($fieldname)) {
            return $this->createFieldnameFromString($fieldname, $tablename);
        }

        return $this->createFieldnameFromInterface($fieldname, $tablename);
    }


    /**
     * Erzeugt ein TablenameValue aus einem String.
     *
     * @param string $tablename
     *
     * @return TablenameValue
     *
     * @throws Exception
     */
    public function createTablenameFromString(string $tablename): TablenameValue
    {
        return TablenameValue::fromString($tablename, $this->tablenameValidator);
    }


    /**
     * Erzeugt ein TablenameValue aus einem TablenamesInterface.
     *
     * @param TablenamesInterface $tablename
     *
     * @return TablenameValue
     *
     * @throws Exception
     */
    public function createTablenameFromInterface(TablenamesInterface $tablename): TablenameValue
    {
        return TablenameValue::fromInterface($tablename, $this->tablenameValidator);
    }


    /**
     * Erestellt ein TablenameValue aus einem String oder einem TablenamesInterface.
     * (Fasssade für $this->createTablenameFromString() und $this->createTablenameFromInterface())
     *
     * @param TablenamesInterface|string $tablename
     *
     * @return TablenameValue
     *
     * @throws Exception
     */
    public function createTablenameFromStringOrInterface(TablenamesInterface|string $tablename): TablenameValue
    {
        if (true === \is_string($tablename)) {
            return $this->createTablenameFromString($tablename);
        }

        return $this->createTablenameFromInterface($tablename);
    }
}
