<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190422032625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create table to keep Keyword and Report data';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE keyword_report (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, keyword BIGINT UNSIGNED NOT NULL, adwords_number BIGINT NOT NULL, links_number BIGINT NOT NULL, result_num BIGINT NOT NULL, search_time DOUBLE PRECISION NOT NULL, page_content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, keyword VARCHAR(255) NOT NULL, imported_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE keyword_report');
        $this->addSql('DROP TABLE keyword');
    }
}
