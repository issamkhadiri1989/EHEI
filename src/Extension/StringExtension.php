<?php

declare(strict_types=1);

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{
    const MAX = 10;

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('minimize', [$this, 'minimizeFilter'])
        ];
    }

    /**
     * truncates the input string if the string has more than 10 characters
     * and appends ... to the end.
     *
     * @param string $text The input string
     *
     * @return string The output string
     */
    public function minimizeFilter(string $text)
    {
        if (\strlen($text) < self::MAX) {
            return $text;
        }

        return \sprintf('%s...', \mb_substr($text, 0, self::MAX)) ;
    }
}