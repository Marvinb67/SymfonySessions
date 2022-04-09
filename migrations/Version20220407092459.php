<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407092459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_formation (id INT AUTO_INCREMENT NOT NULL, categories_id INT NOT NULL, intitule VARCHAR(100) NOT NULL, INDEX IDX_1A213E77A21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planifier (id INT AUTO_INCREMENT NOT NULL, sessions_id INT NOT NULL, modules_formation_id INT NOT NULL, INDEX IDX_E539894AF17C4D8C (sessions_id), INDEX IDX_E539894ABC1163DA (modules_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, formateurs_id INT NOT NULL, formations_id INT NOT NULL, intitule VARCHAR(100) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, places_theoriques INT NOT NULL, places_reserves INT NOT NULL, INDEX IDX_D044D5D4FB0881C8 (formateurs_id), INDEX IDX_D044D5D43BF5B0C2 (formations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_stagiaire (session_id INT NOT NULL, stagiaire_id INT NOT NULL, INDEX IDX_C80B23B613FECDF (session_id), INDEX IDX_C80B23BBBA93DD6 (stagiaire_id), PRIMARY KEY(session_id, stagiaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, sexe VARCHAR(10) NOT NULL, date_naissance DATE NOT NULL, ville VARCHAR(30) NOT NULL, email VARCHAR(30) NOT NULL, telephone VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module_formation ADD CONSTRAINT FK_1A213E77A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE planifier ADD CONSTRAINT FK_E539894AF17C4D8C FOREIGN KEY (sessions_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE planifier ADD CONSTRAINT FK_E539894ABC1163DA FOREIGN KEY (modules_formation_id) REFERENCES module_formation (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D43BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session_stagiaire ADD CONSTRAINT FK_C80B23B613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_stagiaire ADD CONSTRAINT FK_C80B23BBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module_formation DROP FOREIGN KEY FK_1A213E77A21214B7');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4FB0881C8');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D43BF5B0C2');
        $this->addSql('ALTER TABLE planifier DROP FOREIGN KEY FK_E539894ABC1163DA');
        $this->addSql('ALTER TABLE planifier DROP FOREIGN KEY FK_E539894AF17C4D8C');
        $this->addSql('ALTER TABLE session_stagiaire DROP FOREIGN KEY FK_C80B23B613FECDF');
        $this->addSql('ALTER TABLE session_stagiaire DROP FOREIGN KEY FK_C80B23BBBA93DD6');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE module_formation');
        $this->addSql('DROP TABLE planifier');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_stagiaire');
        $this->addSql('DROP TABLE stagiaire');
    }
}
