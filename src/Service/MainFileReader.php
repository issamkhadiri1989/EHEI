<?php

declare(strict_types=1);

namespace App\Service;

class MainFileReader
{
    /** @var array */
    private $fileReaders;

    public function __construct()
    {
        $this->fileReaders = [];
    }

    public function addReader(FileReader $reader, string $alias)
    {
        $this->fileReaders[$alias] = $reader;
    }

    public function getReader($alias): ?FileReader
    {
        if (\array_key_exists($alias, $this->fileReaders)) {
            return $this->fileReaders[$alias];
        }

        return null;
    }

    public function dump()
    {
        foreach ($this->fileReaders as $alias => $reader) {
            dump($alias, get_class($reader));
        }
    }
}
