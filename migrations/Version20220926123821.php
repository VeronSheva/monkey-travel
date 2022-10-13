<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926123821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO trip VALUES 
                        (1, 500, "Very cool trip to Egypt", "Egypt-7", "2022-01-10 00:00:00", "2022-01-17 00:00:00", 7), 
                        (2, 400, "Very cool trip to Turkey", "Turkey", "2022-01-11 00:00:00", "2022-01-18 00:00:00", 7), 
                        (3, 700, "Very cool trip to Egypt", "Egypt-10", "2022-01-10 00:00:00", "2022-01-20 00:00:00", 10), 
                        (4, 2700, "Very cool trip to Maldives", "Maldives-15", "2022-02-01 00:00:00", "2022-02-16 00:00:00", 15); 
                      ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM trip WHERE id IN(1,2,3,4)');
    }
}
