<?php

/**
 * @since       07.09.2024 - 11:21
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Database\Valueobjects;

use Esit\Valueobjects\Classes\Database\Enums\TablenamesInterface;
use Esit\Valueobjects\Classes\Database\Exceptions\NotAValidTablenameException;
use Esit\Valueobjects\Classes\Database\Services\Validators\TablenameValidator;

class TablenameValue implements \Stringable
{


    /**
     * @var string
     */
    private string $value;


    /**
     * @param string             $value
     * @param TablenameValidator $validator
     *
     * @throws \Doctrine\DBAL\Exception
     */
    protected function __construct(string $value, TablenameValidator $validator)
    {
        if (!$validator->validate($value)) {
            throw new NotAValidTablenameException('string is no valid table name: ' . $value);
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
     * Erzeugt aus einem String ein TablenameValue-Objekt.
     *
     * @param string             $value
     * @param TablenameValidator $validator
     *
     * @return self
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public static function fromString(string $value, TablenameValidator $validator): self
    {
        return new self($value, $validator);
    }


    /**
     * Erzeugt aus einem DatabasenameInterface ein DatabasenameValue-Objekt.
     *
     * @param TablenamesInterface $fieldname
     * @param TablenameValidator  $validator
     *
     * @return self
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public static function fromInterface(TablenamesInterface $fieldname, TablenameValidator $validator): self
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
