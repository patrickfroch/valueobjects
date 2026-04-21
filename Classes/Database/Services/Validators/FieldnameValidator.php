<?php

/**
 * @since       07.09.2024 - 12:06
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
use Esit\Valueobjects\Classes\Database\Valueobjects\TablenameValue;

class FieldnameValidator
{


    /**
     * @param SchemaManagerFactory $schemaManagerFactory
     */
    public function __construct(private readonly SchemaManagerFactory $schemaManagerFactory)
    {
    }


    /**
     * Prüft, ob das Feld mit dem übergebenen Namen in der übergebenen Tabelle existert.
     *
     * @param string         $fieldname
     * @param TablenameValue $tablename
     *
     * @return bool
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function validate(string $fieldname, TablenameValue $tablename): bool
    {
        $fieldnames = $this->schemaManagerFactory->getSchemaManager()->listTableColumns($tablename->value());

        foreach ($fieldnames as $fieldnameFromDb) {
            if ($fieldnameFromDb->getName() === $fieldname) {
                return true;
            }
        }

        return false;
    }
}
