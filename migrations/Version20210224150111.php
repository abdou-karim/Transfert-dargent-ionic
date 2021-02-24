<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224150111 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction ADD date_retrait DATE DEFAULT NULL, DROP date_dexpiration, CHANGE code code VARCHAR(255) DEFAULT NULL, CHANGE part_etat part_etat INT DEFAULT NULL, CHANGE part_entreprise part_entreprise INT DEFAULT NULL, CHANGE part_agence part_agence INT DEFAULT NULL, CHANGE part_agence_depot part_agence_depot INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction ADD date_dexpiration DATE NOT NULL, DROP date_retrait, CHANGE code code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE part_etat part_etat INT NOT NULL, CHANGE part_entreprise part_entreprise INT NOT NULL, CHANGE part_agence part_agence INT NOT NULL, CHANGE part_agence_depot part_agence_depot INT NOT NULL');
    }
}
