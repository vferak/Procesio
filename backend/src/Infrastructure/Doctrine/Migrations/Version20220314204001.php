<?php

declare(strict_types=1);

namespace Procesio\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314204001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_processes ADD CONSTRAINT FK_B514DB9B3E968293 FOREIGN KEY (process_uuid) REFERENCES process (uuid)');
        $this->addSql('ALTER TABLE project_processes ADD CONSTRAINT FK_B514DB9BE8EE98BE FOREIGN KEY (project_uuid) REFERENCES project (uuid)');
        $this->addSql('ALTER TABLE project_processes ADD CONSTRAINT FK_B514DB9BA393D2FB FOREIGN KEY (state) REFERENCES state (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_processes');
        $this->addSql('ALTER TABLE package CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE workspace_uuid workspace_uuid CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE comes_from comes_from CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE process CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE comes_from comes_from CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE process_package CHANGE process_uuid process_uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE package_uuid package_uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE project CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_by created_by CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE workspace_uuid workspace_uuid CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE package_uuid package_uuid CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE state CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE subprocess CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE process_uuid process_uuid CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE comes_from comes_from CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_workspace CHANGE user_uuid user_uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE workspace_uuid workspace_uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstName firstName VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastName lastName VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE workspace CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
