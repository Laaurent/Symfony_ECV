<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104140014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP picture');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6BAF7870F675F31B ON ingredient (author_id)');
        $this->addSql('ALTER TABLE user DROP pseudo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870F675F31B');
        $this->addSql('DROP INDEX IDX_6BAF7870F675F31B ON ingredient');
        $this->addSql('ALTER TABLE ingredient ADD picture LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD pseudo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
