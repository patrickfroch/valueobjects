<?php

/**
 * @since       13.03.2024 - 09:56
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Classes\Duration\Interfaces;

interface DurationInterface
{


    public function value(): int;


    public function isNegativ(): bool;


    public function parse(string $format, string $prefix = ''): string;
}
