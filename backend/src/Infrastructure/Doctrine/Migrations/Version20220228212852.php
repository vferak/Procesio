<?php

declare(strict_types=1);

namespace Procesio\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228212852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /*$this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE6A32356E');
        $this->addSql('DROP INDEX fk_2fb3d0ee6a32356e ON project');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE6A32356E ON project (package_uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6A32356E FOREIGN KEY (package_uuid) REFERENCES package (uuid)');
        $this->addSql('ALTER TABLE subprocess ADD process_uuid CHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE subprocess ADD CONSTRAINT FK_CD7FB0593E968293 FOREIGN KEY (process_uuid) REFERENCES subprocess (uuid)');
        $this->addSql('CREATE INDEX IDX_CD7FB0593E968293 ON subprocess (process_uuid)');*/
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE process CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE6A32356E');
        $this->addSql('ALTER TABLE project CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE workspace_uuid workspace_uuid CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE package_uuid package_uuid CHAR(36) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_2fb3d0ee6a32356e ON project');
        $this->addSql('CREATE INDEX FK_2FB3D0EE6A32356E ON project (package_uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6A32356E FOREIGN KEY (package_uuid) REFERENCES package (uuid)');
        $this->addSql('ALTER TABLE subprocess DROP FOREIGN KEY FK_CD7FB0593E968293');
        $this->addSql('DROP INDEX IDX_CD7FB0593E968293 ON subprocess');
        $this->addSql('ALTER TABLE subprocess DROP process_uuid, CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstName firstName VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastName lastName VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE workspace CHANGE uuid uuid CHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
