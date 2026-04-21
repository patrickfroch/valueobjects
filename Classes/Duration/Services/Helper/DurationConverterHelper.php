<?php

/**
 * @since       19.03.2024 - 12:43
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Duration\Services\Helper;

use Esit\Valueobjects\Classes\Duration\Library\ConversionFactors;
use Esit\Valueobjects\Classes\Duration\Services\Calculators\DurationCalculator;
use Esit\Valueobjects\Classes\Duration\Services\Converter\DurationConverter;

class DurationConverterHelper
{


    /**
     * @param DurationCalculator $calculator
     * @param DurationConverter  $converter
     */
    public function __construct(
        private readonly DurationCalculator $calculator,
        private readonly DurationConverter $converter
    ) {
    }


    /**
     * Gibt die Gesamtzahl der Jahre zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getTotalYears(int $time): int
    {
        return $this->converter->getTotalAmountOfUnit($time, ConversionFactors::SECONDS_PER_YEAR);
    }


    /**
     * Gibt die Monate ohne Jahre zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getMonthsCount(int $time): int
    {
        return $this->converter->getCountOfUnit(
            $time,
            ConversionFactors::SECONDS_PER_MONTH,
            ConversionFactors::SECONDS_PER_YEAR
        );
    }


    /**
     * Gibt die Gesamtzahl der Monate zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getTotalMonths(int $time): int
    {
        return $this->converter->getTotalAmountOfUnit($time, ConversionFactors::SECONDS_PER_MONTH);
    }


    /**
     * Gibt die Wochen ohne Monate und Jahre zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getWeeksCount(int $time): int
    {
        return $this->converter->getCountOfUnit(
            $time,
            ConversionFactors::SECONDS_PER_WEEK,
            ConversionFactors::SECONDS_PER_MONTH
        );
    }


    /**
     * Gibt die Gesamtzahl der Wochen zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getTotalWeeks(int $time): int
    {
        return $this->converter->getTotalAmountOfUnit($time, ConversionFactors::SECONDS_PER_WEEK);
    }


    /**
     * Gibt die Tage ohne Wochen, Monate, ... zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getDaysCount(int $time): int
    {
        return $this->converter->getCountOfUnit(
            $time,
            ConversionFactors::SECONDS_PER_DAY,
            ConversionFactors::SECONDS_PER_WEEK
        );
    }


    /**
     * Gibt die Gesamtzahl der Tage zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getTotalDays(int $time): int
    {
        return $this->converter->getTotalAmountOfUnit($time, ConversionFactors::SECONDS_PER_DAY);
    }


    /**
     * Gibt die Anzahl der Stunden als absoluten Wert zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getHoursCount(int $time): int
    {
        return $this->converter->getCountOfUnit(
            $time,
            ConversionFactors::SECONDS_PER_HOUR,
            ConversionFactors::SECONDS_PER_DAY
        );
    }


    /**
     * Gibt die Gesamtzahl der Minuten mit den Stunden, Wochen, ... zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getTotalHours(int $time): int
    {
        return $this->converter->getTotalAmountOfUnit($time, ConversionFactors::SECONDS_PER_HOUR);
    }


    /**
     * Gibt die Sekunden der ganzen Minuten ohne Stunden, Wochen, ... zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getMinutesCount(int $time): int
    {
        return $this->converter->getCountOfUnit(
            $time,
            ConversionFactors::SECONDS_PER_MINUTE,
            ConversionFactors::SECONDS_PER_HOUR
        );
    }


    /**
     * Gibt die Gesamtzahl der Minuten mit den Stunden, Wochen, ... zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getTotalMinutes(int $time): int
    {
        return $this->converter->getTotalAmountOfUnit($time, ConversionFactors::SECONDS_PER_MINUTE);
    }


    /**
     * Gibt die restlichen Sekunden ohne Stunden und Minuten zurück.
     *
     * @param int $time
     *
     * @return int
     */
    public function getSconds(int $time): int
    {
        return $this->calculator->modulo($time, ConversionFactors::SECONDS_PER_MINUTE);
    }
}
