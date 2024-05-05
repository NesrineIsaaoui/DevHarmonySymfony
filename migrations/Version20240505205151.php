<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505205151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, id_formateur INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, note INT NOT NULL, description TEXT NOT NULL, INDEX fk_idformateur (id_formateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE abonnement (id_formation INT NOT NULL, id_etudiant INT NOT NULL, INDEX IDX_351268BBC0759D98 (id_formation), INDEX IDX_351268BB21A5CE76 (id_etudiant), PRIMARY KEY(id_formation, id_etudiant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, id_test INT DEFAULT NULL, id_etudiant INT DEFAULT NULL, note_obtenue INT NOT NULL, UNIQUE INDEX UNIQ_CFBDFA14535F620E (id_test), UNIQUE INDEX UNIQ_CFBDFA1421A5CE76 (id_etudiant), INDEX fk_idtest (id_test), INDEX fk_idetudiant (id_etudiant), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionquiz (id INT AUTO_INCREMENT NOT NULL, id_quiz INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, reponse_correcte VARCHAR(255) NOT NULL, reponse_fausse1 VARCHAR(255) NOT NULL, reponse_fausse2 VARCHAR(255) NOT NULL, reponse_fausse3 VARCHAR(255) NOT NULL, note INT NOT NULL, INDEX fk_idquiz_questionquiz (id_quiz), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questiontest (id INT AUTO_INCREMENT NOT NULL, id_test INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, reponse_correcte VARCHAR(255) NOT NULL, reponse_fausse1 VARCHAR(255) NOT NULL, reponse_fausse2 VARCHAR(255) NOT NULL, reponse_fausse3 VARCHAR(255) NOT NULL, note INT NOT NULL, INDEX fk_idtest_questiontest (id_test), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, id_formateur INT DEFAULT NULL, sujet VARCHAR(255) NOT NULL, INDEX fk_idformateur_quiz (id_formateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, id_formation INT DEFAULT NULL, id_formateur INT DEFAULT NULL, sujet VARCHAR(255) NOT NULL, nb_etudiant_passes INT NOT NULL, nb_etudiants_admis INT NOT NULL, duree INT NOT NULL, INDEX fk_formation (id_formation), INDEX fk_idformateur_test (id_formateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF6D43C268 FOREIGN KEY (id_formateur) REFERENCES user (id)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBC0759D98 FOREIGN KEY (id_formation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB21A5CE76 FOREIGN KEY (id_etudiant) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14535F620E FOREIGN KEY (id_test) REFERENCES test (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1421A5CE76 FOREIGN KEY (id_etudiant) REFERENCES user (id)');
        $this->addSql('ALTER TABLE questionquiz ADD CONSTRAINT FK_D96D02102F32E690 FOREIGN KEY (id_quiz) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE questiontest ADD CONSTRAINT FK_A500868E535F620E FOREIGN KEY (id_test) REFERENCES test (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA926D43C268 FOREIGN KEY (id_formateur) REFERENCES user (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CC0759D98 FOREIGN KEY (id_formation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C6D43C268 FOREIGN KEY (id_formateur) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF6D43C268');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBC0759D98');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BB21A5CE76');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14535F620E');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1421A5CE76');
        $this->addSql('ALTER TABLE questionquiz DROP FOREIGN KEY FK_D96D02102F32E690');
        $this->addSql('ALTER TABLE questiontest DROP FOREIGN KEY FK_A500868E535F620E');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA926D43C268');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CC0759D98');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C6D43C268');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE questionquiz');
        $this->addSql('DROP TABLE questiontest');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE test');
    }
}
