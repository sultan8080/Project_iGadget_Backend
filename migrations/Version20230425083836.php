<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425083836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_status (ord_status_id INT AUTO_INCREMENT NOT NULL, order_status VARCHAR(255) NOT NULL, PRIMARY KEY(ord_status_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_returns MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON order_returns');
        $this->addSql('ALTER TABLE order_returns CHANGE id ord_returns_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE order_returns ADD PRIMARY KEY (ord_returns_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_status');
        $this->addSql('ALTER TABLE order_returns MODIFY ord_returns_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON order_returns');
        $this->addSql('ALTER TABLE order_returns CHANGE ord_returns_id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE order_returns ADD PRIMARY KEY (id)');
    }
}
