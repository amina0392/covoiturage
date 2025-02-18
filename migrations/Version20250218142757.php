<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218142757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3377F287F');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3377F287F ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP id_voiture');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F50EAE44');
        $this->addSql('ALTER TABLE voiture CHANGE id_utilisateur id_utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD id_voiture INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3377F287F FOREIGN KEY (id_voiture) REFERENCES voiture (id_voiture) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3377F287F ON utilisateur (id_voiture)');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F50EAE44');
        $this->addSql('ALTER TABLE voiture CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
