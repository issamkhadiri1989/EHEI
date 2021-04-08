<?php

declare(strict_types=1);

namespace App\Factory;

use App\Service\Mailer;

class MailerFactory
{
    /**
     * Creates the mailer service.
     *
     * @return Mailer the mailer service
     */
    public function createMailer(): Mailer
    {
        $mailer = new Mailer();
        $mailer->setFrom('some.user@gmail.com');

        return $mailer;
    }

    /**
     * Creates the mailer service.
     *
     * @return Mailer the mailer service
     */
    public static function alertAdmins(): Mailer
    {
        $mailer = new Mailer();
        $mailer->setFrom('super.admin.user@gmail.com');

        return $mailer;
    }
}
