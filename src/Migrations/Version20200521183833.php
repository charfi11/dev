<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521183833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE astuce DROP FOREIGN KEY FK_977D78072DCDAFC');
        $this->addSql('DROP INDEX IDX_977D78072DCDAFC ON astuce');
        $this->addSql('ALTER TABLE astuce DROP vote_id');
        $this->addSql('ALTER TABLE vote ADD astuces_id INT DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, ADD likes INT NOT NULL, ADD dislikes INT NOT NULL, DROP result');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564BDF30E57 FOREIGN KEY (astuces_id) REFERENCES astuce (id)');
        $this->addSql('CREATE INDEX IDX_5A108564BDF30E57 ON vote (astuces_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE astuce ADD vote_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE astuce ADD CONSTRAINT FK_977D78072DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id)');
        $this->addSql('CREATE INDEX IDX_977D78072DCDAFC ON astuce (vote_id)');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564BDF30E57');
        $this->addSql('DROP INDEX IDX_5A108564BDF30E57 ON vote');
        $this->addSql('ALTER TABLE vote ADD result VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP astuces_id, DROP name, DROP likes, DROP dislikes');
    }
}
