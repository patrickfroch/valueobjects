<?php

/**
 * @since       15.03.2024 - 10:39
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Duration\Library;

enum DurationFormatParts
{
    // NICHT GENUTZT: Y
    case Y; // Anzahl der Jahre
    // case y;
    // NICHT GENUTZT: M
    case M; // Anzahl der ganzen Monate (ohne Dezimalteil)
    // NICHT GENUTZT: m
    case m; // Anzahl der Restmonate (abzüglich der größeren Einheiten wie z. B. Jahre und ohne Dezimalteil)
    case W; // Anzahl der ganzen Wochen (ohne Dezimalteil)
    // NICHT GENUTZT: w
    case w; // Anzahl der Restwochen (abzüglich der größeren Einheiten wie z. B. Monate und ohne Dezimalteil)
    case D; // Anzahl der ganzen Tage (ohne Dezimalteil)
    case d; // Anzahl der Resttage (abzüglich der größeren Einheiten wie z. B. Wochen und ohne Dezimalteil)
    case H; // Anzahl der ganzen Stunden (ohne Dezimalteil)
    case h; // Anzahl der Reststunden (abzüglich der größeren Einheiten wie z. B. Tage und ohne Dezimalteil)
    case I; // Anzahl der ganzen Minuten (ohne Dezimalteil)
    case i; // Anzahl der Restminuten (abzüglich der größeren Einheiten wie z. B. Stunden und ohne Dezimalteil)
    case S; // Anzahl der ganzen Sekunden (ohne Dezimalteil, keine Konveriterung nötig!)
    case s; // Anzahl der Restsekunden (abzüglich der größeren Einheiten wie z. B. Minuten und ohne Dezimalteil)

    /*
    NICHT GENUTZT:
    Da die Länge eines Montas, sowie eines Jahres (wegen der Schaltjahre) nicht festgelegt ist,
    können diese Werte nicht pauschal berechnet werden!
    */
}
