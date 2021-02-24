<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223170518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence_partenaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_client VARCHAR(255) NOT NULL, numero_client VARCHAR(255) NOT NULL, nom_beneficiaire VARCHAR(255) NOT NULL, numero_beneficiaire VARCHAR(255) NOT NULL, cni_beneficiaire VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, agence_partenaire_id INT DEFAULT NULL, numero_compte VARCHAR(255) NOT NULL, solde VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_CFF65260A76ED395 (user_id), UNIQUE INDEX UNIQ_CFF65260D2F1AFD6 (agence_partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, abreviation VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, montant VARCHAR(255) NOT NULL, date_transfert DATE NOT NULL, date_dexpiration DATE NOT NULL, type VARCHAR(255) NOT NULL, part_etat INT NOT NULL, part_entreprise INT NOT NULL, part_agence INT NOT NULL, part_agence_depot INT NOT NULL, INDEX IDX_723705D1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, agence_partenaire_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649CCFA12B8 (profile_id), INDEX IDX_8D93D649D2F1AFD6 (agence_partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260D2F1AFD6 FOREIGN KEY (agence_partenaire_id) REFERENCES agence_partenaire (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D2F1AFD6 FOREIGN KEY (agence_partenaire_id) REFERENCES agence_partenaire (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260D2F1AFD6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D2F1AFD6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('DROP TABLE agence_partenaire');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
    }
}
