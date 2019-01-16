<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190116071700 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(128) NOT NULL, price_location DOUBLE PRECISION NOT NULL, place_capacity INT NOT NULL, ville VARCHAR(128) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, disponible TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_729F519BC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_of_room (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BC54C8C93 FOREIGN KEY (type_id) REFERENCES type_of_room (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BC54C8C93');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE type_of_room');
    }
}
