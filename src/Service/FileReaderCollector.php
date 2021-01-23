<?php

declare(strict_types=1);

namespace App\Service;

class FileReaderCollector
{
    /** @var iterable */
    private $readers;

    public function __construct(iterable $readers)
    {
        $this->readers = $readers;
    }

    public function dump()
    {
        foreach ($this->readers as $key => $reader) {
            dump($key, get_class($reader));
        }
    }
}