<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251126083718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, flms_id INT DEFAULT NULL, note INT NOT NULL, commentaire VARCHAR(255) NOT NULL, INDEX IDX_8F91ABF08B14C92C (flms_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, couleur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cat_flm (cat_id INT NOT NULL, flm_id INT NOT NULL, INDEX IDX_CDB782DEE6ADA943 (cat_id), INDEX IDX_CDB782DE63E1E454 (flm_id), PRIMARY KEY(cat_id, flm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flm (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_sorti INT NOT NULL, image VARCHAR(255) NOT NULL, duree INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF08B14C92C FOREIGN KEY (flms_id) REFERENCES flm (id)');
        $this->addSql('ALTER TABLE cat_flm ADD CONSTRAINT FK_CDB782DEE6ADA943 FOREIGN KEY (cat_id) REFERENCES cat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cat_flm ADD CONSTRAINT FK_CDB782DE63E1E454 FOREIGN KEY (flm_id) REFERENCES flm (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF08B14C92C');
        $this->addSql('ALTER TABLE cat_flm DROP FOREIGN KEY FK_CDB782DEE6ADA943');
        $this->addSql('ALTER TABLE cat_flm DROP FOREIGN KEY FK_CDB782DE63E1E454');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP TABLE cat_flm');
        $this->addSql('DROP TABLE flm');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
