<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260428123940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flm_acteur (flm_id INT NOT NULL, acteur_id INT NOT NULL, INDEX IDX_406F300463E1E454 (flm_id), INDEX IDX_406F3004DA6F574A (acteur_id), PRIMARY KEY(flm_id, acteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flm_acteur ADD CONSTRAINT FK_406F300463E1E454 FOREIGN KEY (flm_id) REFERENCES flm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flm_acteur ADD CONSTRAINT FK_406F3004DA6F574A FOREIGN KEY (acteur_id) REFERENCES acteur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flm_acteur DROP FOREIGN KEY FK_406F300463E1E454');
        $this->addSql('ALTER TABLE flm_acteur DROP FOREIGN KEY FK_406F3004DA6F574A');
        $this->addSql('DROP TABLE flm_acteur');
    }
}
