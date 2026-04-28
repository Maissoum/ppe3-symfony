<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260428122644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flm_cat DROP FOREIGN KEY FK_99EF5F3263E1E454');
        $this->addSql('ALTER TABLE flm_cat DROP FOREIGN KEY FK_99EF5F32E6ADA943');
        $this->addSql('DROP TABLE flm_cat');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flm_cat (flm_id INT NOT NULL, cat_id INT NOT NULL, INDEX IDX_99EF5F3263E1E454 (flm_id), INDEX IDX_99EF5F32E6ADA943 (cat_id), PRIMARY KEY(flm_id, cat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE flm_cat ADD CONSTRAINT FK_99EF5F3263E1E454 FOREIGN KEY (flm_id) REFERENCES flm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flm_cat ADD CONSTRAINT FK_99EF5F32E6ADA943 FOREIGN KEY (cat_id) REFERENCES cat (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE acteur');
    }
}
