<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181230101917 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student_subject DROP FOREIGN KEY FK_16F88B82B723AF33');
        $this->addSql('ALTER TABLE student_subject DROP FOREIGN KEY FK_16F88B8233F7B9AB');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_subject');
        $this->addSql('DROP TABLE subject1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE student (id SMALLINT AUTO_INCREMENT NOT NULL, student_id VARCHAR(15) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX UNIQ_B723AF33CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE student_subject (id INT AUTO_INCREMENT NOT NULL, student SMALLINT NOT NULL, subject1 SMALLINT NOT NULL, INDEX IDX_16F88B8233F7B9AB (subject1), INDEX IDX_16F88B82B723AF33 (student), UNIQUE INDEX UNIQ_16F88B82B723AF3333F7B9AB (student, subject1), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE subject1 (id SMALLINT AUTO_INCREMENT NOT NULL, code VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX UNIQ_33F7B9AB77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE student_subject ADD CONSTRAINT FK_16F88B8233F7B9AB FOREIGN KEY (subject1) REFERENCES subject1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_subject ADD CONSTRAINT FK_16F88B82B723AF33 FOREIGN KEY (student) REFERENCES student (id) ON DELETE CASCADE');
    }
}
