<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181225194026 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE student_enrolled_subject (user_id INT NOT NULL, subject_id INT NOT NULL, status VARCHAR(100) NOT NULL, INDEX IDX_5B4E2520A76ED395 (user_id), INDEX IDX_5B4E252023EDC87 (subject_id), PRIMARY KEY(user_id, subject_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, subject_name VARCHAR(80) NOT NULL, subject_key VARCHAR(16) NOT NULL, program VARCHAR(100) NOT NULL, ects INT NOT NULL, semester_full_time_student INT NOT NULL, semester_part_time_student INT NOT NULL, optional_subject VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, status VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_enrolled_subject ADD CONSTRAINT FK_5B4E2520A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE student_enrolled_subject ADD CONSTRAINT FK_5B4E252023EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student_enrolled_subject DROP FOREIGN KEY FK_5B4E252023EDC87');
        $this->addSql('ALTER TABLE student_enrolled_subject DROP FOREIGN KEY FK_5B4E2520A76ED395');
        $this->addSql('DROP TABLE student_enrolled_subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE user');
    }
}
