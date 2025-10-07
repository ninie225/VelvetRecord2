<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251007070425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE disc DROP FOREIGN KEY disc_ibfk_1');
        $this->addSql('ALTER TABLE disc CHANGE title title VARCHAR(255) NOT NULL, CHANGE year year INT NOT NULL, CHANGE label label VARCHAR(255) NOT NULL, CHANGE genre genre VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX artist_id ON disc');
        $this->addSql('CREATE INDEX IDX_2AF5530B7970CF8 ON disc (artist_id)');
        $this->addSql('ALTER TABLE disc ADD CONSTRAINT disc_ibfk_1 FOREIGN KEY (artist_id) REFERENCES artist (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE artist CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE disc DROP FOREIGN KEY FK_2AF5530B7970CF8');
        $this->addSql('ALTER TABLE disc CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE year year INT DEFAULT NULL, CHANGE label label VARCHAR(255) DEFAULT NULL, CHANGE genre genre VARCHAR(255) DEFAULT NULL, CHANGE price price NUMERIC(6, 2) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_2af5530b7970cf8 ON disc');
        $this->addSql('CREATE INDEX artist_id ON disc (artist_id)');
        $this->addSql('ALTER TABLE disc ADD CONSTRAINT FK_2AF5530B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
    }
}
