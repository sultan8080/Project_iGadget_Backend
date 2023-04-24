<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424140346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON categories');
        $this->addSql('ALTER TABLE categories CHANGE id category_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE categories ADD PRIMARY KEY (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories MODIFY category_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON categories');
        $this->addSql('ALTER TABLE categories CHANGE category_id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE categories ADD PRIMARY KEY (id)');
    }
}
