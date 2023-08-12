<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802082938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre ADD categorie_chambre_id INT DEFAULT NULL, ADD equipement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF5DEB5F8 FOREIGN KEY (categorie_chambre_id) REFERENCES categorie_chambre (id)');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id)');
        $this->addSql('CREATE INDEX IDX_C509E4FF5DEB5F8 ON chambre (categorie_chambre_id)');
        $this->addSql('CREATE INDEX IDX_C509E4FF806F0F5C ON chambre (equipement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF5DEB5F8');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF806F0F5C');
        $this->addSql('DROP INDEX IDX_C509E4FF5DEB5F8 ON chambre');
        $this->addSql('DROP INDEX IDX_C509E4FF806F0F5C ON chambre');
        $this->addSql('ALTER TABLE chambre DROP categorie_chambre_id, DROP equipement_id');
    }
}
