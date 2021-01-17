<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210116192850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, penality DOUBLE PRECISION NOT NULL, payment_date DATETIME NOT NULL, transaction_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sticker (id INT AUTO_INCREMENT NOT NULL, payment_id INT NOT NULL, user_id INT NOT NULL, registration_number VARCHAR(255) NOT NULL, year INT NOT NULL, fuel VARCHAR(255) NOT NULL, fiscal_power INT NOT NULL, circulation_date DATE NOT NULL, UNIQUE INDEX UNIQ_8FEDBCFD4C3A3BB (payment_id), INDEX IDX_8FEDBCFDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, hash VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sticker ADD CONSTRAINT FK_8FEDBCFD4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE sticker ADD CONSTRAINT FK_8FEDBCFDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sticker DROP FOREIGN KEY FK_8FEDBCFD4C3A3BB');
        $this->addSql('ALTER TABLE sticker DROP FOREIGN KEY FK_8FEDBCFDA76ED395');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE sticker');
        $this->addSql('DROP TABLE user');
    }
}
