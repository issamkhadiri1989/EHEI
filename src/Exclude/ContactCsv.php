<?php

namespace App\Exclude;

class ContactCsv implements ContactInterface
{
    /**
     * @var string
     */
    private $contactCsv;

    public function __construct(string $contactCsv)
    {
        $this->contactCsv = $contactCsv;
    }

    /**
     * @param string $id The contact id
     *
     * @return array|null An associative array representing the contact or null if not found
     */
    public function find(string $id): ?array
    {
        $contact = null;
        $fid = fopen($this->contactCsv, 'r');
        while (false !== ($line = fgetcsv($fid, null, ';'))  && null === $contact) {
            if ($line[0] === $id) {
                $contact = [
                    'id' => $line[0],
                    'firstName' => $line[1],
                    'lastName' => $line[2],
                    'phone' => $line[3],
                    'from' => 'file',
                ];
            }
        }
        fclose($fid);

        return $contact;
    }

    /**
     * @param array $contact The contact to add
     */
    public function add(array $contact): void
    {
        $fid = fopen($this->contactCsv, 'a');
        fputcsv($fid, $contact);
        fclose($fid);
    }
}