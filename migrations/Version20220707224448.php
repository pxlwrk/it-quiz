<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707224448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE event_session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event_session (id INT NOT NULL, title VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event_session_topic (event_session_id INT NOT NULL, topic_id INT NOT NULL, PRIMARY KEY(event_session_id, topic_id))');
        $this->addSql('CREATE INDEX IDX_6264D66139D135F0 ON event_session_topic (event_session_id)');
        $this->addSql('CREATE INDEX IDX_6264D6611F55203D ON event_session_topic (topic_id)');
        $this->addSql('CREATE TABLE event_session_quiz (event_session_id INT NOT NULL, quiz_id INT NOT NULL, PRIMARY KEY(event_session_id, quiz_id))');
        $this->addSql('CREATE INDEX IDX_8F70F04B39D135F0 ON event_session_quiz (event_session_id)');
        $this->addSql('CREATE INDEX IDX_8F70F04B853CD175 ON event_session_quiz (quiz_id)');
        $this->addSql('ALTER TABLE event_session_topic ADD CONSTRAINT FK_6264D66139D135F0 FOREIGN KEY (event_session_id) REFERENCES event_session (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_session_topic ADD CONSTRAINT FK_6264D6611F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_session_quiz ADD CONSTRAINT FK_8F70F04B39D135F0 FOREIGN KEY (event_session_id) REFERENCES event_session (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_session_quiz ADD CONSTRAINT FK_8F70F04B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question ADD solution_a BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE question ADD solution_b BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE question ADD solution_c BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE question DROP solution');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_session_topic DROP CONSTRAINT FK_6264D66139D135F0');
        $this->addSql('ALTER TABLE event_session_quiz DROP CONSTRAINT FK_8F70F04B39D135F0');
        $this->addSql('DROP SEQUENCE event_session_id_seq CASCADE');
        $this->addSql('DROP TABLE event_session');
        $this->addSql('DROP TABLE event_session_topic');
        $this->addSql('DROP TABLE event_session_quiz');
        $this->addSql('ALTER TABLE question ADD solution VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE question DROP solution_a');
        $this->addSql('ALTER TABLE question DROP solution_b');
        $this->addSql('ALTER TABLE question DROP solution_c');
    }
}
