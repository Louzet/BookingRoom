<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190129102847 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, client VARCHAR(255) NOT NULL, reservation VARCHAR(255) NOT NULL, abandon_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = MyISAM');
        $this->addSql('ALTER TABLE reservation ADD title VARCHAR(255) NOT NULL, ADD current_status LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE room ADD professionnal_id INT NOT NULL, CHANGE price_location price_location DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_729F519B7FC96A42 ON room (professionnal_id)');
        $this->addSql('ALTER TABLE user ADD birthday DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE historique');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F54177093');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955DC304035');
        $this->addSql('ALTER TABLE reservation DROP title, DROP current_status');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BC54C8C93');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B3DA3A00C');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BA73F0036');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B7FC96A42');
        $this->addSql('DROP INDEX IDX_729F519B7FC96A42 ON room');
        $this->addSql('ALTER TABLE room DROP professionnal_id, CHANGE price_location price_location DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user DROP birthday');
    }
}
