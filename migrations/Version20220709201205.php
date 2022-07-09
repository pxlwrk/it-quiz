<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220709201205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE answer (id INT NOT NULL, question_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE event_session_quiz');
        $this->addSql('ALTER TABLE question DROP answer_a');
        $this->addSql('ALTER TABLE question DROP answer_b');
        $this->addSql('ALTER TABLE question DROP answer_c');
        $this->addSql('ALTER TABLE question DROP solution_a');
        $this->addSql('ALTER TABLE question DROP solution_b');
        $this->addSql('ALTER TABLE question DROP solution_c');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE answer_id_seq CASCADE');
        $this->addSql('CREATE TABLE event_session_quiz (event_session_id INT NOT NULL, quiz_id INT NOT NULL, PRIMARY KEY(event_session_id, quiz_id))');
        $this->addSql('CREATE INDEX idx_8f70f04b853cd175 ON event_session_quiz (quiz_id)');
        $this->addSql('CREATE INDEX idx_8f70f04b39d135f0 ON event_session_quiz (event_session_id)');
        $this->addSql('DROP TABLE answer');
        $this->addSql('ALTER TABLE question ADD answer_a VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question ADD answer_b VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question ADD answer_c VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question ADD solution_a BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE question ADD solution_b BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE question ADD solution_c BOOLEAN NOT NULL');
    }
}
