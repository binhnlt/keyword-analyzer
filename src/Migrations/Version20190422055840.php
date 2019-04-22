<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190422055840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add source name to Report table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE keyword_report ADD source VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE keyword_report DROP source');
    }
}
