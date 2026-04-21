<?php

/**
 * @since       18.03.2024 - 13:50
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Duration\Interfaces;

use Esit\Valueobjects\Classes\Duration\Valueobjects\DurationValue;

interface DurationCalculatorInterface
{


    public function add(DurationValue $durationValue): DurationValue;


    public function subtract(DurationValue $durationValue): DurationValue;


    public function multiply(int $operand): DurationValue;


    public function divide(int $operand): DurationValue;
}
