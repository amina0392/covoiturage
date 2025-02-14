<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212144113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id_reservation INT AUTO_INCREMENT NOT NULL, id_utilisateur INT NOT NULL, id_trajet INT NOT NULL, statut VARCHAR(255) NOT NULL, date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_42C8495550EAE44 (id_utilisateur), INDEX IDX_42C84955D6C1C61 (id_trajet), PRIMARY KEY(id_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id_role INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(255) NOT NULL, PRIMARY KEY(id_role)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id_trajet INT AUTO_INCREMENT NOT NULL, id_utilisateur INT NOT NULL, ville_depart INT NOT NULL, ville_arrivee INT NOT NULL, date_heure DATETIME NOT NULL, places_restantes INT NOT NULL, detail_trajet LONGTEXT DEFAULT NULL, INDEX IDX_2B5BA98C50EAE44 (id_utilisateur), INDEX IDX_2B5BA98CDDDF1A2 (ville_depart), INDEX IDX_2B5BA98C704088A8 (ville_arrivee), PRIMARY KEY(id_trajet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id_utilisateur INT AUTO_INCREMENT NOT NULL, id_role INT NOT NULL, id_ville INT NOT NULL, id_voiture INT DEFAULT NULL, nom VARCHAR(200) NOT NULL, prenom VARCHAR(200) NOT NULL, email VARCHAR(200) NOT NULL, mot_de_passe VARCHAR(60) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), INDEX IDX_1D1C63B3DC499668 (id_role), INDEX IDX_1D1C63B3AD4698F3 (id_ville), UNIQUE INDEX UNIQ_1D1C63B3377F287F (id_voiture), PRIMARY KEY(id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id_ville INT AUTO_INCREMENT NOT NULL, code_postale VARCHAR(10) NOT NULL, nom_commune VARCHAR(200) NOT NULL, PRIMARY KEY(id_ville)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id_voiture INT AUTO_INCREMENT NOT NULL, marque VARCHAR(100) NOT NULL, modele VARCHAR(100) NOT NULL, immatriculation VARCHAR(50) NOT NULL, nb_places INT NOT NULL, UNIQUE INDEX UNIQ_E9E2810FBE73422E (immatriculation), PRIMARY KEY(id_voiture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495550EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D6C1C61 FOREIGN KEY (id_trajet) REFERENCES trajet (id_trajet) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CDDDF1A2 FOREIGN KEY (ville_depart) REFERENCES ville (id_ville)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C704088A8 FOREIGN KEY (ville_arrivee) REFERENCES ville (id_ville)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DC499668 FOREIGN KEY (id_role) REFERENCES role (id_role)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3AD4698F3 FOREIGN KEY (id_ville) REFERENCES ville (id_ville)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3377F287F FOREIGN KEY (id_voiture) REFERENCES voiture (id_voiture) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495550EAE44');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D6C1C61');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C50EAE44');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CDDDF1A2');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C704088A8');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DC499668');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3AD4698F3');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3377F287F');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
