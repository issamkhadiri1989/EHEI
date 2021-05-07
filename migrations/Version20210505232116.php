<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210505232116 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE circulation_tax ADD CONSTRAINT FK_27F33AE4C3423909 FOREIGN KEY (driver_id) REFERENCES driver (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_27F33AE4C3423909 ON circulation_tax (driver_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE circulation_tax DROP FOREIGN KEY FK_27F33AE4C3423909');
        $this->addSql('DROP INDEX UNIQ_27F33AE4C3423909 ON circulation_tax');
    }
}
