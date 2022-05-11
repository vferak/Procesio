<?php

declare(strict_types=1);

namespace Procesio\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511171420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE package (uuid CHAR(36) NOT NULL, workspace_uuid CHAR(36) DEFAULT NULL, comes_from CHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_DE686795959D2364 (workspace_uuid), INDEX IDX_DE686795674B1641 (comes_from), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process (uuid CHAR(36) NOT NULL, comes_from CHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_861D1896674B1641 (comes_from), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process_package (process_uuid CHAR(36) NOT NULL, package_uuid CHAR(36) NOT NULL, INDEX IDX_9610BD403E968293 (process_uuid), INDEX IDX_9610BD406A32356E (package_uuid), PRIMARY KEY(process_uuid, package_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (uuid CHAR(36) NOT NULL, created_by CHAR(36) DEFAULT NULL, workspace_uuid CHAR(36) DEFAULT NULL, package_uuid CHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_2FB3D0EEDE12AB56 (created_by), INDEX IDX_2FB3D0EE959D2364 (workspace_uuid), INDEX IDX_2FB3D0EE6A32356E (package_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_processes (process_uuid CHAR(36) NOT NULL, project_uuid CHAR(36) NOT NULL, state CHAR(36) DEFAULT NULL, INDEX IDX_B514DB9B3E968293 (process_uuid), INDEX IDX_B514DB9BE8EE98BE (project_uuid), INDEX IDX_B514DB9BA393D2FB (state), PRIMARY KEY(process_uuid, project_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_subprocesses (subprocess_uuid CHAR(36) NOT NULL, project_uuid CHAR(36) NOT NULL, state CHAR(36) DEFAULT NULL, INDEX IDX_1AE0D11685D245F3 (subprocess_uuid), INDEX IDX_1AE0D116E8EE98BE (project_uuid), INDEX IDX_1AE0D116A393D2FB (state), PRIMARY KEY(subprocess_uuid, project_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (uuid CHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subprocess (uuid CHAR(36) NOT NULL, process_uuid CHAR(36) DEFAULT NULL, comes_from CHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_CD7FB0593E968293 (process_uuid), INDEX IDX_CD7FB059674B1641 (comes_from), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (uuid CHAR(36) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, firstName VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_workspace (user_uuid CHAR(36) NOT NULL, workspace_uuid CHAR(36) NOT NULL, INDEX IDX_8D748DFDABFE1C6F (user_uuid), INDEX IDX_8D748DFD959D2364 (workspace_uuid), PRIMARY KEY(user_uuid, workspace_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workspace (uuid CHAR(36) NOT NULL, user_uuid CHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_8D940019ABFE1C6F (user_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795959D2364 FOREIGN KEY (workspace_uuid) REFERENCES workspace (uuid)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795674B1641 FOREIGN KEY (comes_from) REFERENCES package (uuid)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896674B1641 FOREIGN KEY (comes_from) REFERENCES process (uuid)');
        $this->addSql('ALTER TABLE process_package ADD CONSTRAINT FK_9610BD403E968293 FOREIGN KEY (process_uuid) REFERENCES process (uuid)');
        $this->addSql('ALTER TABLE process_package ADD CONSTRAINT FK_9610BD406A32356E FOREIGN KEY (package_uuid) REFERENCES package (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEDE12AB56 FOREIGN KEY (created_by) REFERENCES users (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE959D2364 FOREIGN KEY (workspace_uuid) REFERENCES workspace (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6A32356E FOREIGN KEY (package_uuid) REFERENCES package (uuid)');
        $this->addSql('ALTER TABLE project_processes ADD CONSTRAINT FK_B514DB9B3E968293 FOREIGN KEY (process_uuid) REFERENCES process (uuid)');
        $this->addSql('ALTER TABLE project_processes ADD CONSTRAINT FK_B514DB9BE8EE98BE FOREIGN KEY (project_uuid) REFERENCES project (uuid)');
        $this->addSql('ALTER TABLE project_processes ADD CONSTRAINT FK_B514DB9BA393D2FB FOREIGN KEY (state) REFERENCES state (uuid)');
        $this->addSql('ALTER TABLE project_subprocesses ADD CONSTRAINT FK_1AE0D11685D245F3 FOREIGN KEY (subprocess_uuid) REFERENCES subprocess (uuid)');
        $this->addSql('ALTER TABLE project_subprocesses ADD CONSTRAINT FK_1AE0D116E8EE98BE FOREIGN KEY (project_uuid) REFERENCES project (uuid)');
        $this->addSql('ALTER TABLE project_subprocesses ADD CONSTRAINT FK_1AE0D116A393D2FB FOREIGN KEY (state) REFERENCES state (uuid)');
        $this->addSql('ALTER TABLE subprocess ADD CONSTRAINT FK_CD7FB0593E968293 FOREIGN KEY (process_uuid) REFERENCES process (uuid)');
        $this->addSql('ALTER TABLE subprocess ADD CONSTRAINT FK_CD7FB059674B1641 FOREIGN KEY (comes_from) REFERENCES subprocess (uuid)');
        $this->addSql('ALTER TABLE user_workspace ADD CONSTRAINT FK_8D748DFDABFE1C6F FOREIGN KEY (user_uuid) REFERENCES users (uuid)');
        $this->addSql('ALTER TABLE user_workspace ADD CONSTRAINT FK_8D748DFD959D2364 FOREIGN KEY (workspace_uuid) REFERENCES workspace (uuid)');
        $this->addSql('ALTER TABLE workspace ADD CONSTRAINT FK_8D940019ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES users (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795674B1641');
        $this->addSql('ALTER TABLE process_package DROP FOREIGN KEY FK_9610BD406A32356E');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE6A32356E');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896674B1641');
        $this->addSql('ALTER TABLE process_package DROP FOREIGN KEY FK_9610BD403E968293');
        $this->addSql('ALTER TABLE project_processes DROP FOREIGN KEY FK_B514DB9B3E968293');
        $this->addSql('ALTER TABLE subprocess DROP FOREIGN KEY FK_CD7FB0593E968293');
        $this->addSql('ALTER TABLE project_processes DROP FOREIGN KEY FK_B514DB9BE8EE98BE');
        $this->addSql('ALTER TABLE project_subprocesses DROP FOREIGN KEY FK_1AE0D116E8EE98BE');
        $this->addSql('ALTER TABLE project_processes DROP FOREIGN KEY FK_B514DB9BA393D2FB');
        $this->addSql('ALTER TABLE project_subprocesses DROP FOREIGN KEY FK_1AE0D116A393D2FB');
        $this->addSql('ALTER TABLE project_subprocesses DROP FOREIGN KEY FK_1AE0D11685D245F3');
        $this->addSql('ALTER TABLE subprocess DROP FOREIGN KEY FK_CD7FB059674B1641');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEDE12AB56');
        $this->addSql('ALTER TABLE user_workspace DROP FOREIGN KEY FK_8D748DFDABFE1C6F');
        $this->addSql('ALTER TABLE workspace DROP FOREIGN KEY FK_8D940019ABFE1C6F');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795959D2364');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE959D2364');
        $this->addSql('ALTER TABLE user_workspace DROP FOREIGN KEY FK_8D748DFD959D2364');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE process_package');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_processes');
        $this->addSql('DROP TABLE project_subprocesses');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE subprocess');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_workspace');
        $this->addSql('DROP TABLE workspace');
    }
}
