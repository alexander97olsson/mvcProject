<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524061328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE highscore ADD COLUMN average DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__highscore AS SELECT id, name, score, time FROM highscore');
        $this->addSql('DROP TABLE highscore');
        $this->addSql('CREATE TABLE highscore (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, score INTEGER NOT NULL, time VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO highscore (id, name, score, time) SELECT id, name, score, time FROM __temp__highscore');
        $this->addSql('DROP TABLE __temp__highscore');
    }
}
