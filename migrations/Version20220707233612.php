<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707233612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event_session_quiz');
        $this->addSql('ALTER TABLE quiz ADD event_session_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA9239D135F0 FOREIGN KEY (event_session_id) REFERENCES event_session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A412FA9239D135F0 ON quiz (event_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE event_session_quiz (event_session_id INT NOT NULL, quiz_id INT NOT NULL, PRIMARY KEY(event_session_id, quiz_id))');
        $this->addSql('CREATE INDEX idx_8f70f04b853cd175 ON event_session_quiz (quiz_id)');
        $this->addSql('CREATE INDEX idx_8f70f04b39d135f0 ON event_session_quiz (event_session_id)');
        $this->addSql('ALTER TABLE event_session_quiz ADD CONSTRAINT fk_8f70f04b39d135f0 FOREIGN KEY (event_session_id) REFERENCES event_session (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_session_quiz ADD CONSTRAINT fk_8f70f04b853cd175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz DROP CONSTRAINT FK_A412FA9239D135F0');
        $this->addSql('DROP INDEX IDX_A412FA9239D135F0');
        $this->addSql('ALTER TABLE quiz DROP event_session_id');
    }
}
