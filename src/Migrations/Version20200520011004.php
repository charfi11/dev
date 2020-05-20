<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520011004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE astuce ADD user_id INT DEFAULT NULL, ADD categoris_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE astuce ADD CONSTRAINT FK_977D780A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE astuce ADD CONSTRAINT FK_977D780C987EF6E FOREIGN KEY (categoris_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_977D780A76ED395 ON astuce (user_id)');
        $this->addSql('CREATE INDEX IDX_977D780C987EF6E ON astuce (categoris_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE astuce DROP FOREIGN KEY FK_977D780A76ED395');
        $this->addSql('ALTER TABLE astuce DROP FOREIGN KEY FK_977D780C987EF6E');
        $this->addSql('DROP INDEX IDX_977D780A76ED395 ON astuce');
        $this->addSql('DROP INDEX IDX_977D780C987EF6E ON astuce');
        $this->addSql('ALTER TABLE astuce DROP user_id, DROP categoris_id');
    }
}
