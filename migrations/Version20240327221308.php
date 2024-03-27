<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327221308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promo MODIFY code INT NOT NULL');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY fk');
        $this->addSql('DROP INDEX id ON promo');
        $this->addSql('DROP INDEX `primary` ON promo');
        $this->addSql('ALTER TABLE promo ADD users_id INT DEFAULT NULL, DROP code, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE isActive is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFB67B3B43D ON promo (users_id)');
        $this->addSql('ALTER TABLE promo ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user CHANGE numTel num_tel INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFB67B3B43D');
        $this->addSql('DROP INDEX IDX_B0139AFB67B3B43D ON promo');
        $this->addSql('ALTER TABLE promo ADD code INT AUTO_INCREMENT NOT NULL, DROP users_id, CHANGE id id INT NOT NULL, CHANGE is_active isActive TINYINT(1) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (code)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT fk FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id ON promo (id)');
        $this->addSql('ALTER TABLE user CHANGE num_tel numTel INT NOT NULL');
    }
}
