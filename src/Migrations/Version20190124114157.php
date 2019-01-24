<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124114157 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, inscription_ldap_id INT NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(255) DEFAULT NULL, price_location DOUBLE PRECISION NOT NULL, place_capacity INT NOT NULL, ville VARCHAR(128) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, disponible TINYINT(1) NOT NULL, privee TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_729F519BC54C8C93 (type_id), INDEX IDX_729F519B3DA3A00C (inscription_ldap_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_ldap (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, hostname VARCHAR(255) NOT NULL, port INT NOT NULL, basedn VARCHAR(255) NOT NULL, binddn VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, privee TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, salle_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, reserved_at DATETIME NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C84955DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_employ INT NOT NULL, password VARCHAR(64) NOT NULL, name VARCHAR(64) NOT NULL, firstname VARCHAR(64) NOT NULL, birthday DATETIME DEFAULT NULL, hiring_date DATETIME NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_of_room (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BC54C8C93 FOREIGN KEY (type_id) REFERENCES type_of_room (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B3DA3A00C FOREIGN KEY (inscription_ldap_id) REFERENCES inscription_ldap (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DC304035 FOREIGN KEY (salle_id) REFERENCES room (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955DC304035');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B3DA3A00C');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BC54C8C93');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE inscription_ldap');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE type_of_room');
    }
}
