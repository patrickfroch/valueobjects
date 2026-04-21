<?php

/**
 * @since       07.09.2024 - 11:22
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Database\Valueobjects;

use Esit\Valueobjects\Classes\Database\Enums\FieldnamesInterface;
use Esit\Valueobjects\Classes\Database\Exceptions\NotAValidFieldnameException;
use Esit\Valueobjects\Classes\Database\Services\Validators\FieldnameValidator;

class FieldnameValue implements \Stringable
{


    /**
     * @var string
     */
    private string $value;


    /**
     * @param string             $value
     * @param TablenameValue     $tablename
     * @param FieldnameValidator $validator
     *
     * @throws \Doctrine\DBAL\Exception
     */
    protected function __construct(string $value, TablenameValue $tablename, FieldnameValidator $validator)
    {
        if (!$validator->validate($value, $tablename)) {
            throw new NotAValidFieldnameException('string is no valid field name: ' . $value);
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
     * Erzeugt aus einem String ein FieldnameValue-Objekt.
     *
     * @param string             $value
     * @param TablenameValue     $tablename
     * @param FieldnameValidator $validator
     *
     * @return self
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public static function fromString(string $value, TablenameValue $tablename, FieldnameValidator $validator): self
    {
        return new self($value, $tablename, $validator);
    }


    /**
     * Erzeugt aus einem FieldnameInterface ein FieldnameValue-Objekt.
     *
     * @param FieldnamesInterface $fieldname
     * @param TablenameValue      $tablename
     * @param FieldnameValidator  $validator
     *
     * @return self
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public static function fromInterface(
        FieldnamesInterface $fieldname,
        TablenameValue $tablename,
        FieldnameValidator $validator
    ): self {
        return new self($fieldname->name, $tablename, $validator);
    }


    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
