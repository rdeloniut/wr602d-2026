<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260211073946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, is_active TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tool_plan (tool_id INT NOT NULL, plan_id INT NOT NULL, INDEX IDX_6181B368F7B22CC (tool_id), INDEX IDX_6181B36E899029B (plan_id), PRIMARY KEY (tool_id, plan_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE tool_plan ADD CONSTRAINT FK_6181B368F7B22CC FOREIGN KEY (tool_id) REFERENCES tool (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tool_plan ADD CONSTRAINT FK_6181B36E899029B FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tools_plan DROP FOREIGN KEY `FK_11C43473752C489C`');
        $this->addSql('ALTER TABLE tools_plan DROP FOREIGN KEY `FK_11C43473E899029B`');
        $this->addSql('DROP TABLE tools');
        $this->addSql('DROP TABLE tools_plan');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tools (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, icon VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, is_active TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tools_plan (tools_id INT NOT NULL, plan_id INT NOT NULL, INDEX IDX_11C43473752C489C (tools_id), INDEX IDX_11C43473E899029B (plan_id), PRIMARY KEY (tools_id, plan_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tools_plan ADD CONSTRAINT `FK_11C43473752C489C` FOREIGN KEY (tools_id) REFERENCES tools (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tools_plan ADD CONSTRAINT `FK_11C43473E899029B` FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tool_plan DROP FOREIGN KEY FK_6181B368F7B22CC');
        $this->addSql('ALTER TABLE tool_plan DROP FOREIGN KEY FK_6181B36E899029B');
        $this->addSql('DROP TABLE tool');
        $this->addSql('DROP TABLE tool_plan');
    }
}
