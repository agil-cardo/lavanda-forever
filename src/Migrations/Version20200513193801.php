<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200513193801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comentario ADD mensaje_id INT NOT NULL');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E7024C54F362 FOREIGN KEY (mensaje_id) REFERENCES mensaje (id)');
        $this->addSql('CREATE INDEX IDX_4B91E7024C54F362 ON comentario (mensaje_id)');
        $this->addSql('ALTER TABLE user ADD nombre VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E7024C54F362');
        $this->addSql('DROP INDEX IDX_4B91E7024C54F362 ON comentario');
        $this->addSql('ALTER TABLE comentario DROP mensaje_id');
        $this->addSql('ALTER TABLE user DROP nombre');
    }
}
