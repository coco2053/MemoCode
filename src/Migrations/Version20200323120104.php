<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323120104 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE memo (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, language_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, article_order INT NOT NULL, INDEX IDX_AB4A902A7294869C (article_id), INDEX IDX_AB4A902A82F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, content LONGTEXT NOT NULL, article_order INT NOT NULL, INDEX IDX_3B8BA7C77294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE memo ADD CONSTRAINT FK_AB4A902A7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE memo ADD CONSTRAINT FK_AB4A902A82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C77294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE memo DROP FOREIGN KEY FK_AB4A902A7294869C');
        $this->addSql('ALTER TABLE text DROP FOREIGN KEY FK_3B8BA7C77294869C');
        $this->addSql('ALTER TABLE memo DROP FOREIGN KEY FK_AB4A902A82F1BAF4');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE memo');
        $this->addSql('DROP TABLE text');
    }
}
