<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307084406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id_reservation INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_utilisateur INTEGER NOT NULL, id_trajet INTEGER NOT NULL, statut VARCHAR(255) NOT NULL, date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_42C8495550EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_42C84955D6C1C61 FOREIGN KEY (id_trajet) REFERENCES trajet (id_trajet) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_42C8495550EAE44 ON reservation (id_utilisateur)');
        $this->addSql('CREATE INDEX IDX_42C84955D6C1C61 ON reservation (id_trajet)');
        $this->addSql('CREATE TABLE role (id_role INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_role VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE trajet (id_trajet INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_utilisateur INTEGER NOT NULL, id_ville_depart INTEGER NOT NULL, id_ville_arrivee INTEGER NOT NULL, date_heure DATETIME NOT NULL, places_restantes INTEGER NOT NULL, detail_trajet CLOB DEFAULT NULL, CONSTRAINT FK_2B5BA98C50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2B5BA98C2E1C84D0 FOREIGN KEY (id_ville_depart) REFERENCES ville (id_ville) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2B5BA98CCE6859CD FOREIGN KEY (id_ville_arrivee) REFERENCES ville (id_ville) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2B5BA98C50EAE44 ON trajet (id_utilisateur)');
        $this->addSql('CREATE INDEX IDX_2B5BA98C2E1C84D0 ON trajet (id_ville_depart)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CCE6859CD ON trajet (id_ville_arrivee)');
        $this->addSql('CREATE TABLE utilisateur (id_utilisateur INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_role INTEGER NOT NULL, id_ville INTEGER NOT NULL, nom VARCHAR(200) NOT NULL, prenom VARCHAR(200) NOT NULL, email VARCHAR(200) NOT NULL, mot_de_passe VARCHAR(60) NOT NULL, CONSTRAINT FK_1D1C63B3DC499668 FOREIGN KEY (id_role) REFERENCES role (id_role) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1D1C63B3AD4698F3 FOREIGN KEY (id_ville) REFERENCES ville (id_ville) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3DC499668 ON utilisateur (id_role)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3AD4698F3 ON utilisateur (id_ville)');
        $this->addSql('CREATE TABLE ville (id_ville INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code_postale VARCHAR(10) NOT NULL, nom_commune VARCHAR(200) NOT NULL)');
        $this->addSql('CREATE TABLE voiture (id_voiture INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_utilisateur INTEGER NOT NULL, marque VARCHAR(100) NOT NULL, modele VARCHAR(100) NOT NULL, immatriculation VARCHAR(50) NOT NULL, nb_places INTEGER NOT NULL, CONSTRAINT FK_E9E2810F50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810FBE73422E ON voiture (immatriculation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810F50EAE44 ON voiture (id_utilisateur)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
