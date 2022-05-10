<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510124511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tpz_roles (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tpz_roles (user_id INT NOT NULL, tpz_roles_id INT NOT NULL, INDEX IDX_222A769EA76ED395 (user_id), INDEX IDX_222A769EB3DE3B4C (tpz_roles_id), PRIMARY KEY(user_id, tpz_roles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_tpz_roles ADD CONSTRAINT FK_222A769EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tpz_roles ADD CONSTRAINT FK_222A769EB3DE3B4C FOREIGN KEY (tpz_roles_id) REFERENCES tpz_roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD tpz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64945215261 FOREIGN KEY (tpz_id) REFERENCES tpz (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64945215261 ON user (tpz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_tpz_roles DROP FOREIGN KEY FK_222A769EB3DE3B4C');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tpz_roles');
        $this->addSql('DROP TABLE user_tpz_roles');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64945215261');
        $this->addSql('DROP INDEX IDX_8D93D64945215261 ON user');
        $this->addSql('ALTER TABLE user DROP tpz_id');
    }
}
