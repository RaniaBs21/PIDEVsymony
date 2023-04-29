<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422134707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE cours CHANGE Sous_categorie Sous_categorie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE points ADD CONSTRAINT FK_27BA8E29BF396750 FOREIGN KEY (id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX iduser ON points (id)');
        $this->addSql('ALTER TABLE question_quiz CHANGE idQuiz id_quiz INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question_quiz ADD CONSTRAINT FK_FAFC177D2F32E690 FOREIGN KEY (id_quiz) REFERENCES quiz (id_quiz)');
        $this->addSql('CREATE INDEX id_quiz_2 ON question_quiz (id_quiz)');
        $this->addSql('CREATE INDEX id_quiz ON question_quiz (id_quiz)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92BF396750 FOREIGN KEY (id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX iduser ON quiz (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE admin CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C9F1045A3');
        $this->addSql('ALTER TABLE cours CHANGE Sous_categorie Sous_categorie INT NOT NULL');
        $this->addSql('ALTER TABLE points DROP FOREIGN KEY FK_27BA8E29BF396750');
        $this->addSql('DROP INDEX iduser ON points');
        $this->addSql('ALTER TABLE question_quiz DROP FOREIGN KEY FK_FAFC177D2F32E690');
        $this->addSql('DROP INDEX id_quiz_2 ON question_quiz');
        $this->addSql('DROP INDEX id_quiz ON question_quiz');
        $this->addSql('ALTER TABLE question_quiz CHANGE id_quiz idQuiz INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92BF396750');
        $this->addSql('DROP INDEX iduser ON quiz');
    }
}
