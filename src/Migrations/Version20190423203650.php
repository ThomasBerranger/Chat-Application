<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190423203650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE chat_room (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_room_user (chat_room_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C87A2E561819BCFA (chat_room_id), INDEX IDX_C87A2E56A76ED395 (user_id), PRIMARY KEY(chat_room_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, chat_room_id INT NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6BD307FF675F31B (author_id), INDEX IDX_B6BD307F1819BCFA (chat_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat_room_user ADD CONSTRAINT FK_C87A2E561819BCFA FOREIGN KEY (chat_room_id) REFERENCES chat_room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chat_room_user ADD CONSTRAINT FK_C87A2E56A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1819BCFA FOREIGN KEY (chat_room_id) REFERENCES chat_room (id)');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chat_room_user DROP FOREIGN KEY FK_C87A2E561819BCFA');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1819BCFA');
        $this->addSql('DROP TABLE chat_room');
        $this->addSql('DROP TABLE chat_room_user');
        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE user DROP created_at');
    }
}
