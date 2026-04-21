<?php

/**
 * @since       13.03.2024 - 14:48
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Duration\Library;

class ConversionFactors
{

    public const SECONDS_PER_MINUTE = 60;       // 60 Sekunden

    public const SECONDS_PER_HOUR = 3600;       // 60 x 60 Sekunden

    public const SECONDS_PER_DAY = 86400;       // 24 * 60 Minuten

    public const SECONDS_PER_WEEK = 604800;     // 7 x 24 Stunden

    public const SECONDS_PER_MONTH = 2419200;   // 4 x 7 Tage (28 Tage)

    public const SECONDS_PER_YEAR = 29030400;   // 12 x 4 Wochen (12 x 28 = 336 Tage)
}
