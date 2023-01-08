<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108202201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD related_to_id INT DEFAULT NULL, DROP service');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE40B4AC4E FOREIGN KEY (related_to_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE40B4AC4E ON booking (related_to_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE40B4AC4E');
        $this->addSql('DROP INDEX IDX_E00CEDDE40B4AC4E ON booking');
        $this->addSql('ALTER TABLE booking ADD service VARCHAR(255) DEFAULT NULL, DROP related_to_id');
    }
}
