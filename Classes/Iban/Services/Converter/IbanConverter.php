<?php

/**
 * @version     1.0.0
 *
 * @since       18.09.22 - 16:47
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Iban\Services\Converter;

class IbanConverter
{
    /**
     * Entfernt evtl. vorhandene Leerzeichen.
     *
     * @param string $value
     *
     * @return string
     */
    public function convertToIban(string $value): string
    {
        return \str_replace(' ', '', $value);
    }


    /**
     * Gibt einen formatierten Wert zurück, bei dem in der Iban nach dem Bankcode,
     * die Zahlen in vierer Gruppen unterteilt sind.
     *
     * @param string $value
     *
     * @return string
     */
    public function convertToFormated(string $value): string
    {
        $temp = '';

        foreach (\mb_str_split($value) as $i => $char) {
            if (0 === $i % 4) {
                $temp .= ' ';
            }

            $temp .= $char;
        }

        return \trim($temp);
    }
}
