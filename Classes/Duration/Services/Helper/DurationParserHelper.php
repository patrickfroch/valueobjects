<?php

/**
 * @since       19.03.2024 - 12:47
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Duration\Services\Helper;

use Esit\Valueobjects\Classes\Duration\Library\DurationFormatParts;

class DurationParserHelper
{


    public function __construct(private readonly DurationConverterHelper $helper)
    {
    }


    /**
     * Fassade für den Konverter.
     * Ruft die Konvertiertung anhand des in $key übergebenen Buchstabens auf.
     *
     * @param DurationFormatParts $key
     * @param int                 $time
     *
     * @return int
     */
    public function parseToken(DurationFormatParts $key, int $time): int
    {
        return match ($key) {
            DurationFormatParts::S => $time,
            DurationFormatParts::s => $this->helper->getSconds($time),
            DurationFormatParts::I => $this->helper->getTotalMinutes($time),
            DurationFormatParts::i => $this->helper->getMinutesCount($time),
            DurationFormatParts::H => $this->helper->getTotalHours($time),
            DurationFormatParts::h => $this->helper->getHoursCount($time),
            DurationFormatParts::D => $this->helper->getTotalDays($time),
            DurationFormatParts::d => $this->helper->getDaysCount($time),
            DurationFormatParts::W => $this->helper->getTotalWeeks($time),
            /*
            DurationFormatParts::w => $this->helper->getWeeksCount($time),
            DurationFormatParts::M => $this->helper->getTotalMonths($time),
            DurationFormatParts::m => $this->helper->getMonthsCount($time),
            DurationFormatParts::Y => $this->helper->getTotalYears($time),
            */
            default => 0
        };
    }
}
