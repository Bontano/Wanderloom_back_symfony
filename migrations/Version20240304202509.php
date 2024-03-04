<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304202509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE itinary (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE itinary_activity (id INT AUTO_INCREMENT NOT NULL, activity_id INT DEFAULT NULL, itinary_id INT DEFAULT NULL, day_moment VARCHAR(255) NOT NULL, day VARCHAR(255) NOT NULL, INDEX IDX_2967ECD781C06096 (activity_id), INDEX IDX_2967ECD7B897C559 (itinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_itinary (id INT AUTO_INCREMENT NOT NULL, user_creator_id INT NOT NULL, itinary_id INT NOT NULL, favorite TINYINT(1) NOT NULL, INDEX IDX_79E26162C645C84A (user_creator_id), INDEX IDX_79E26162B897C559 (itinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE itinary_activity ADD CONSTRAINT FK_2967ECD781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE itinary_activity ADD CONSTRAINT FK_2967ECD7B897C559 FOREIGN KEY (itinary_id) REFERENCES itinary (id)');
        $this->addSql('ALTER TABLE user_itinary ADD CONSTRAINT FK_79E26162C645C84A FOREIGN KEY (user_creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_itinary ADD CONSTRAINT FK_79E26162B897C559 FOREIGN KEY (itinary_id) REFERENCES itinary (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE itinary_activity DROP FOREIGN KEY FK_2967ECD781C06096');
        $this->addSql('ALTER TABLE itinary_activity DROP FOREIGN KEY FK_2967ECD7B897C559');
        $this->addSql('ALTER TABLE user_itinary DROP FOREIGN KEY FK_79E26162C645C84A');
        $this->addSql('ALTER TABLE user_itinary DROP FOREIGN KEY FK_79E26162B897C559');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE itinary');
        $this->addSql('DROP TABLE itinary_activity');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_itinary');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
