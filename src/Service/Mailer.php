<?php

declare(strict_types=1);

namespace App\Service;

class Mailer
{
    /** @var string */
    private $from;

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    public function sendMail()
    {
        dump($this->from);
    }
}