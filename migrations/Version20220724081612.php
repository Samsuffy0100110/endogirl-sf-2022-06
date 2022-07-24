<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220724081612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, role VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, title VARCHAR(255) NOT NULL, is_read TINYINT(1) DEFAULT NULL, reply LONGTEXT DEFAULT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, summary LONGTEXT DEFAULT NULL, INDEX IDX_FBCE3E7A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, subject_id INT DEFAULT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, reply LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_9D40DE1B23EDC87 (subject_id), INDEX IDX_9D40DE1BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD forum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64929CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64929CCBAD0 ON user (forum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7A12469DE2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64929CCBAD0');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B23EDC87');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP INDEX IDX_8D93D64929CCBAD0 ON user');
        $this->addSql('ALTER TABLE user DROP forum_id');
    }
}
