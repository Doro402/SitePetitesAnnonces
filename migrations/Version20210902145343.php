<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210902145343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E58A3C7387');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E59D86650F');
        $this->addSql('DROP INDEX IDX_F65593E59D86650F ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E58A3C7387 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP user_id_id, DROP categorie_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD user_id_id INT NOT NULL, ADD categorie_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E58A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F65593E59D86650F ON annonce (user_id_id)');
        $this->addSql('CREATE INDEX IDX_F65593E58A3C7387 ON annonce (categorie_id_id)');
    }
}
