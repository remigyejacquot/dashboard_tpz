<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525064225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary ADD agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CAD725330D FOREIGN KEY (agence_id) REFERENCES agency (id)');
        $this->addSql('CREATE INDEX IDX_1CAC12CAD725330D ON commentary (agence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CAD725330D');
        $this->addSql('DROP INDEX IDX_1CAC12CAD725330D ON commentary');
        $this->addSql('ALTER TABLE commentary DROP agence_id');
    }
}
