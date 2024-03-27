<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327222231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo ADD user_id INT DEFAULT NULL, DROP id, CHANGE code code INT AUTO_INCREMENT NOT NULL, CHANGE isActive is_active TINYINT(1) NOT NULL, ADD PRIMARY KEY (code)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFBA76ED395 ON promo (user_id)');
        $this->addSql('ALTER TABLE user CHANGE numTel num_tel INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo MODIFY code INT NOT NULL');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBA76ED395');
        $this->addSql('DROP INDEX IDX_B0139AFBA76ED395 ON promo');
        $this->addSql('DROP INDEX `primary` ON promo');
        $this->addSql('ALTER TABLE promo ADD id INT NOT NULL, DROP user_id, CHANGE code code INT NOT NULL, CHANGE is_active isActive TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE num_tel numTel INT NOT NULL');
    }
}
