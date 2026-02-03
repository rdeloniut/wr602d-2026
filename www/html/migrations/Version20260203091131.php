<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260203091131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE generation_user_contact DROP FOREIGN KEY `FK_59D39840CD956462`');
        $this->addSql('ALTER TABLE generation_user_contact_user_contact DROP FOREIGN KEY `FK_4AD6DCEA40C6E3A6`');
        $this->addSql('ALTER TABLE generation_user_contact_user_contact DROP FOREIGN KEY `FK_4AD6DCEAB099CBD5`');
        $this->addSql('DROP TABLE generation_user_contact');
        $this->addSql('DROP TABLE generation_user_contact_user_contact');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE generation_user_contact (id INT AUTO_INCREMENT NOT NULL, generation_id_id INT DEFAULT NULL, INDEX IDX_59D39840CD956462 (generation_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE generation_user_contact_user_contact (generation_user_contact_id INT NOT NULL, user_contact_id INT NOT NULL, INDEX IDX_4AD6DCEAB099CBD5 (generation_user_contact_id), INDEX IDX_4AD6DCEA40C6E3A6 (user_contact_id), PRIMARY KEY (generation_user_contact_id, user_contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE generation_user_contact ADD CONSTRAINT `FK_59D39840CD956462` FOREIGN KEY (generation_id_id) REFERENCES generation (id)');
        $this->addSql('ALTER TABLE generation_user_contact_user_contact ADD CONSTRAINT `FK_4AD6DCEA40C6E3A6` FOREIGN KEY (user_contact_id) REFERENCES user_contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE generation_user_contact_user_contact ADD CONSTRAINT `FK_4AD6DCEAB099CBD5` FOREIGN KEY (generation_user_contact_id) REFERENCES generation_user_contact (id) ON DELETE CASCADE');
    }
}
