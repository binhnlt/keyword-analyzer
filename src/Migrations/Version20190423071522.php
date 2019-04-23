<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190423071522 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE keyword_report (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, keyword_id BIGINT UNSIGNED NOT NULL, adwords_number BIGINT NOT NULL, links_number BIGINT NOT NULL, result_num BIGINT NOT NULL, search_time DOUBLE PRECISION NOT NULL, source VARCHAR(255) NOT NULL, page_content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_65100DCD115D4552 (keyword_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, keyword VARCHAR(255) NOT NULL UNIQUE, imported_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE keyword_report ADD CONSTRAINT FK_65100DCD115D4552 FOREIGN KEY (keyword_id) REFERENCES keyword (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE keyword_report DROP FOREIGN KEY FK_65100DCD115D4552');
        $this->addSql('DROP TABLE keyword_report');
        $this->addSql('DROP TABLE keyword');
    }
}
