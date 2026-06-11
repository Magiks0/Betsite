<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260611072157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create firsts entities';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, odd DOUBLE PRECISION NOT NULL, date VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, event_id INT DEFAULT NULL, author_id INT DEFAULT NULL, outcome_id INT DEFAULT NULL, INDEX IDX_FBF0EC9B71F7E88B (event_id), INDEX IDX_FBF0EC9BF675F31B (author_id), INDEX IDX_FBF0EC9BE6EE6D63 (outcome_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sport VARCHAR(255) NOT NULL, competitors VARCHAR(255) NOT NULL, date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE outcome (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, current_odd DOUBLE PRECISION NOT NULL, event_id INT NOT NULL, INDEX IDX_30BC6DC271F7E88B (event_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BE6EE6D63 FOREIGN KEY (outcome_id) REFERENCES outcome (id)');
        $this->addSql('ALTER TABLE outcome ADD CONSTRAINT FK_30BC6DC271F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9B71F7E88B');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BF675F31B');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BE6EE6D63');
        $this->addSql('ALTER TABLE outcome DROP FOREIGN KEY FK_30BC6DC271F7E88B');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE outcome');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
