<?php

/**
 * @since       07.09.2024 - 11:45
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Database\Valueobjects;

use Esit\Valueobjects\Classes\Database\Enums\DatabasenamesInterface;
use Esit\Valueobjects\Classes\Database\Exceptions\NotAValidDatabasenameException;
use Esit\Valueobjects\Classes\Database\Services\Validators\DatabasenameValidator;

class DatabasenameValue implements \Stringable
{


    /**
     * @var string
     */
    private string $value;


    /**
     * @param string                $value
     * @param DatabasenameValidator $validator
     *
     * @throws \Doctrine\DBAL\Exception
     */
    protected function __construct(string $value, DatabasenameValidator $validator)
    {
        if (!$validator->validate($value)) {
            throw new NotAValidDatabasenameException('string is no valid database name: ' . $value);
        }

        $this->value = $value;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }


    /**
     * Erzeugt aus einem String ein DatabasenameValue-Objekt.
     *
     * @param string                $value
     * @param DatabasenameValidator $validator
     *
     * @return self
     *
     * @throws \Doctrine\DBAL\Exception
     *
     * @deprecated  use self::fromNameInterface() instead
     */
    public static function fromString(string $value, DatabasenameValidator $validator): self
    {
        return new self($value, $validator);
    }


    /**
     * Erzeugt aus einem DatabasenameInterface ein DatabasenameValue-Objekt.
     *
     * @param DatabasenamesInterface $fieldname
     * @param DatabasenameValidator  $validator
     *
     * @return self
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public static function fromInterface(DatabasenamesInterface $fieldname, DatabasenameValidator $validator): self
    {
        return new self($fieldname->name, $validator);
    }


    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
