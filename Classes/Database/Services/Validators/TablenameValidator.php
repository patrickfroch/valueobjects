<?php

/**
 * @since       07.09.2024 - 11:49
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Database\Services\Validators;

use Esit\Valueobjects\Classes\Database\Services\Factories\SchemaManagerFactory;

class TablenameValidator
{


    /**
     * @param SchemaManagerFactory $schemaManagerFactory
     */
    public function __construct(private readonly SchemaManagerFactory $schemaManagerFactory)
    {
    }


    /**
     * Pürft, ob eine Tabelle mit dem übergebenen Namen existiert.
     *
     * @param string $tablename
     *
     * @return bool
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function validate(string $tablename): bool
    {
        $tables = $this->schemaManagerFactory->getSchemaManager()->listTableNames();

        return \in_array($tablename, $tables, true);
    }
}
