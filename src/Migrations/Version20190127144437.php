<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190127144437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room ADD inscription_ldap_id INT NOT NULL, ADD privee TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B3DA3A00C FOREIGN KEY (inscription_ldap_id) REFERENCES inscription_ldap (id)');
        $this->addSql('CREATE INDEX IDX_729F519B3DA3A00C ON room (inscription_ldap_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B3DA3A00C');
        $this->addSql('DROP INDEX IDX_729F519B3DA3A00C ON room');
        $this->addSql('ALTER TABLE room DROP inscription_ldap_id, DROP privee');
    }
}
