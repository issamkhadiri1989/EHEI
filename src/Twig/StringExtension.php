<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{
    const MAX_COUNT = 35;

    public function getFilters()
    {
        return [
            new TwigFilter('truncate', [$this, 'truncateFunction'])
        ];
    }

    public function truncateFunction(string $text)
    {
        if (\strlen($text) < self::MAX_COUNT) {
            return $text;
        }

        return \mb_substr($text, 0, self::MAX_COUNT) . '...';
    }
}