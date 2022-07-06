<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705220913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE question (id INT NOT NULL, topic_id INT NOT NULL, title VARCHAR(255) NOT NULL, difficulty INT NOT NULL, answer_a VARCHAR(255) NOT NULL, answer_b VARCHAR(255) NOT NULL, answer_c VARCHAR(255) NOT NULL, solution VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6F7494E1F55203D ON question (topic_id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');
        $this->addSql('DROP TABLE question');
    }
}
