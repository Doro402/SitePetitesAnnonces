<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210902141713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP INDEX UNIQ_F65593E58A3C7387, ADD INDEX IDX_F65593E58A3C7387 (categorie_id_id)');
        $this->addSql('ALTER TABLE annonce DROP INDEX UNIQ_F65593E59D86650F, ADD INDEX IDX_F65593E59D86650F (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP INDEX IDX_F65593E59D86650F, ADD UNIQUE INDEX UNIQ_F65593E59D86650F (user_id_id)');
        $this->addSql('ALTER TABLE annonce DROP INDEX IDX_F65593E58A3C7387, ADD UNIQUE INDEX UNIQ_F65593E58A3C7387 (categorie_id_id)');
    }
}
