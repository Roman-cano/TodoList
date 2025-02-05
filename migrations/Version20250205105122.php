<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205105122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_todo (user_id INT NOT NULL, todo_id INT NOT NULL, INDEX IDX_208FFA69A76ED395 (user_id), INDEX IDX_208FFA69EA1EBC33 (todo_id), PRIMARY KEY(user_id, todo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_todo ADD CONSTRAINT FK_208FFA69A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_todo ADD CONSTRAINT FK_208FFA69EA1EBC33 FOREIGN KEY (todo_id) REFERENCES todo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_todo DROP FOREIGN KEY FK_208FFA69A76ED395');
        $this->addSql('ALTER TABLE user_todo DROP FOREIGN KEY FK_208FFA69EA1EBC33');
        $this->addSql('DROP TABLE user_todo');
        $this->addSql('ALTER TABLE user DROP phone');
    }
}
