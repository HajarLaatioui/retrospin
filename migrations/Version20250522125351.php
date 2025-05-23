<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522125351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE artist (id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE genre (id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE loan (
                id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL, 
                user_id INTEGER DEFAULT NULL, 
                vinyl_id INTEGER DEFAULT NULL, 
                borrowed_at DATETIME NOT NULL, 
                returned_at DATETIME DEFAULT NULL, 
                status VARCHAR(255) NOT NULL, 
                insurance_fee DOUBLE PRECISION DEFAULT NULL, 
                price DOUBLE PRECISION DEFAULT NULL, 
                CONSTRAINT FK_C5D30D03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, 
                CONSTRAINT FK_C5D30D033FFFF645 FOREIGN KEY (vinyl_id) REFERENCES vinyl (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C5D30D03A76ED395 ON loan (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C5D30D033FFFF645 ON loan (vinyl_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE vinyl (id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL, artist_id INTEGER DEFAULT NULL, genre_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, release_year INTEGER NOT NULL, description CLOB NOT NULL, is_available BOOLEAN NOT NULL, stock INTEGER DEFAULT 10 NOT NULL, daily_price DOUBLE PRECISION DEFAULT '5' NOT NULL, insurance_fee DOUBLE PRECISION DEFAULT '20' NOT NULL, CONSTRAINT FK_E2E531DB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E2E531D4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E2E531DB7970CF8 ON vinyl (artist_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E2E531D4296D31F ON vinyl (genre_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
    }

    public function down(Schema $schema): void
    {

        $this->addSql(<<<'SQL'
            DROP TABLE artist
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE genre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE loan
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vinyl
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
