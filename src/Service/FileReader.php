<?php

declare(strict_types=1);

namespace App\Service;

interface FileReader
{
    /**
     * @param string $id the user's ID
     *
     * @return array|null the line containing user's info or null if not found
     */
    public function find(string $id): ?array;
}
