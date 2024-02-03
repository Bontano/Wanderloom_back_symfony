<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204132103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE itinary (id INT AUTO_INCREMENT NOT NULL, user_creator_id INT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', country VARCHAR(255) NOT NULL, note VARCHAR(255) DEFAULT NULL, INDEX IDX_21EF7F68C645C84A (user_creator_id), INDEX IDX_21EF7F68A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE itinary_activity (itinary_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_2967ECD7B897C559 (itinary_id), INDEX IDX_2967ECD781C06096 (activity_id), PRIMARY KEY(itinary_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE itinary ADD CONSTRAINT FK_21EF7F68C645C84A FOREIGN KEY (user_creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE itinary ADD CONSTRAINT FK_21EF7F68A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE itinary_activity ADD CONSTRAINT FK_2967ECD7B897C559 FOREIGN KEY (itinary_id) REFERENCES itinary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE itinary_activity ADD CONSTRAINT FK_2967ECD781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE itinary DROP FOREIGN KEY FK_21EF7F68C645C84A');
        $this->addSql('ALTER TABLE itinary DROP FOREIGN KEY FK_21EF7F68A76ED395');
        $this->addSql('ALTER TABLE itinary_activity DROP FOREIGN KEY FK_2967ECD7B897C559');
        $this->addSql('ALTER TABLE itinary_activity DROP FOREIGN KEY FK_2967ECD781C06096');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE itinary');
        $this->addSql('DROP TABLE itinary_activity');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
