<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240802104623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vacancy (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(180) NOT NULL, INDEX IDX_A9346CBD979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacancy_resume (id INT AUTO_INCREMENT NOT NULL, vacancy_id INT DEFAULT NULL, content LONGBLOB NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C3A49EAB433B78C4 (vacancy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vacancy ADD CONSTRAINT FK_A9346CBD979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE vacancy_resume ADD CONSTRAINT FK_C3A49EAB433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancy (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacancy DROP FOREIGN KEY FK_A9346CBD979B1AD6');
        $this->addSql('ALTER TABLE vacancy_resume DROP FOREIGN KEY FK_C3A49EAB433B78C4');
        $this->addSql('DROP TABLE vacancy');
        $this->addSql('DROP TABLE vacancy_resume');
    }
}
