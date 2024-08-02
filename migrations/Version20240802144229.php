<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240802144229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vacancy_resume_mark (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, user_id INT NOT NULL, mark SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5F9FCB4BD262AF09 (resume_id), INDEX IDX_5F9FCB4BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vacancy_resume_mark ADD CONSTRAINT FK_5F9FCB4BD262AF09 FOREIGN KEY (resume_id) REFERENCES vacancy_resume (id)');
        $this->addSql('ALTER TABLE vacancy_resume_mark ADD CONSTRAINT FK_5F9FCB4BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vacancy_resume_mark ADD CONSTRAINT UC_user_resume UNIQUE (user_id,resume_id); ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacancy_resume_mark DROP FOREIGN KEY FK_5F9FCB4BD262AF09');
        $this->addSql('ALTER TABLE vacancy_resume_mark DROP FOREIGN KEY FK_5F9FCB4BA76ED395');
        $this->addSql('DROP TABLE vacancy_resume_mark');
    }
}
