<?php

namespace App\Exclude;

interface ContactInterface
{
    /**
     * @param string $id The contact id
     *
     * @return array|null An associative array representing the contact or null if not found
     */
    public function find(string $id): ?array;

    /**
     * @param array $contact The contact to add
     */
    public function add(array $contact):void;
}