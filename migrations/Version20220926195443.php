<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926195443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'INSERT INTO trip VALUES
                 (5, 600, "Very cool trip to Greece", "Greece-10", "2022-04-12 00:00:00", "2022-04-22 00:00:00", 10)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM trip WHERE id=5');
    }
}
