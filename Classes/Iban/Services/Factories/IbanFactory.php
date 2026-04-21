<?php

/**
 * @version     1.0.0
 *
 * @since       18.09.22 - 16:55
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Iban\Services\Factories;

use Esit\Valueobjects\Classes\Iban\Services\Converter\IbanConverter;
use Esit\Valueobjects\Classes\Iban\Services\Validators\IbanValidator;
use Esit\Valueobjects\Classes\Iban\Valueobjects\IbanValue;

class IbanFactory
{
    /**
     * @var IbanConverter
     */
    private IbanConverter $converter;


    /**
     * @var IbanValidator
     */
    private IbanValidator $validator;


    /**
     * @param IbanConverter $converter
     * @param IbanValidator $validator
     */
    public function __construct(IbanConverter $converter, IbanValidator $validator)
    {
        $this->converter    = $converter;
        $this->validator    = $validator;
    }


    /**
     * Erzeugt aus einem String ein Iban-Objekt.
     * Es spielt keine Rolle, ob der String Leerzeichen zur Gruppierung der Zahlen enthält.
     *
     * @param string $value
     *
     * @return IbanValue
     */
    public function createFromString(string $value): IbanValue
    {
        return IbanValue::fromString($value, $this->converter, $this->validator);
    }
}
