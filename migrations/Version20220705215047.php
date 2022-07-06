<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705215047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE quiz_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE topic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE quiz (id INT NOT NULL, slug VARCHAR(10) NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, contact_email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN quiz.started_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE topic (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE topic_quiz (topic_id INT NOT NULL, quiz_id INT NOT NULL, PRIMARY KEY(topic_id, quiz_id))');
        $this->addSql('CREATE INDEX IDX_9CF99B271F55203D ON topic_quiz (topic_id)');
        $this->addSql('CREATE INDEX IDX_9CF99B27853CD175 ON topic_quiz (quiz_id)');
        $this->addSql('ALTER TABLE topic_quiz ADD CONSTRAINT FK_9CF99B271F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE topic_quiz ADD CONSTRAINT FK_9CF99B27853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE topic_quiz DROP CONSTRAINT FK_9CF99B27853CD175');
        $this->addSql('ALTER TABLE topic_quiz DROP CONSTRAINT FK_9CF99B271F55203D');
        $this->addSql('DROP SEQUENCE quiz_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE topic_id_seq CASCADE');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE topic_quiz');
    }
}
