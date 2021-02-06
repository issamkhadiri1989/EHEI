<?php

declare(strict_types=1);

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class StringExtension extends AbstractExtension
{
    const MAX = 10;

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('tax', [$this, 'computeTaxFunction'])
        ];
    }

    /**
     * Computes the price with tax included.
     *
     * @param float $price The input price
     * @param float $vat The input VAT value
     *
     * @return float The price with tax
     */
    public function computeTaxFunction(float $price, float $vat = 20): float
    {
        return $price * (1 + 0.01 * $vat);
    }

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