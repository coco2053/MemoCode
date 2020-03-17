<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200313160455 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE text (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_3B8BA7C77294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C77294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article DROP content');
        $this->addSql('ALTER TABLE memo ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE memo ADD CONSTRAINT FK_AB4A902A7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_AB4A902A7294869C ON memo (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE text');
        $this->addSql('ALTER TABLE article ADD content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE memo DROP FOREIGN KEY FK_AB4A902A7294869C');
        $this->addSql('DROP INDEX IDX_AB4A902A7294869C ON memo');
        $this->addSql('ALTER TABLE memo DROP article_id');
    }
}
