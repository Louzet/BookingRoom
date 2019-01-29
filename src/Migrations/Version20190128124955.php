<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190128124955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE professionnal (id INT AUTO_INCREMENT NOT NULL, entreprise VARCHAR(190) NOT NULL, siren VARCHAR(14) NOT NULL, address VARCHAR(255) NOT NULL, code_postal VARCHAR(5) NOT NULL, email VARCHAR(190) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', date_inscription DATETIME NOT NULL, derniere_connexion DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1E44040BE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, salle_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, reserved_at DATETIME NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C84955DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, inscription_ldap_id INT NOT NULL, ville_id INT NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(255) NOT NULL, price_location DOUBLE PRECISION NOT NULL, place_capacity INT NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, disponible TINYINT(1) NOT NULL, privee TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_729F519BC54C8C93 (type_id), INDEX IDX_729F519B3DA3A00C (inscription_ldap_id), INDEX IDX_729F519BA73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE type_of_room (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(190) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', date_inscription DATETIME NOT NULL, derniere_connexion DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE villes_france_free (id INT AUTO_INCREMENT NOT NULL, ville_departement VARCHAR(255) NOT NULL, ville_slug VARCHAR(255) NOT NULL, ville_nom VARCHAR(255) NOT NULL, ville_nom_simple VARCHAR(255) NOT NULL, ville_nom_reel VARCHAR(255) NOT NULL, ville_nom_soundex VARCHAR(255) NOT NULL, ville_nom_metaphone VARCHAR(255) NOT NULL, ville_code_postal VARCHAR(255) NOT NULL, ville_commune SMALLINT NOT NULL, ville_code_commune VARCHAR(5) NOT NULL, ville_arrondissement INT NOT NULL, ville_canton VARCHAR(4) DEFAULT NULL, ville_amdi SMALLINT UNSIGNED DEFAULT 0, ville_population_2010 INT NOT NULL, ville_population_1999 INT NOT NULL, ville_population_2012 INT NOT NULL, ville_densite_2010 INT NOT NULL, ville_surface DOUBLE PRECISION NOT NULL, ville_longitude_deg DOUBLE PRECISION NOT NULL, ville_latitude_deg DOUBLE PRECISION NOT NULL, ville_longitude_grd VARCHAR(9) DEFAULT NULL, ville_latitude_grd VARCHAR(8) DEFAULT NULL, ville_longitude_dms VARCHAR(9) DEFAULT NULL, ville_latitude_dms VARCHAR(8) DEFAULT NULL, ville_zmin INT DEFAULT NULL, ville_zmax INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = MyISAM');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DC304035 FOREIGN KEY (salle_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BC54C8C93 FOREIGN KEY (type_id) REFERENCES type_of_room (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B3DA3A00C FOREIGN KEY (inscription_ldap_id) REFERENCES inscription_ldap (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BA73F0036 FOREIGN KEY (ville_id) REFERENCES villes_france_free (id)');
        $this->addSql('ALTER TABLE contact CHANGE email email VARCHAR(190) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F54177093');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955DC304035');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BC54C8C93');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BA73F0036');
        $this->addSql('DROP TABLE professionnal');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE type_of_room');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE villes_france_free');
        $this->addSql('ALTER TABLE contact CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
