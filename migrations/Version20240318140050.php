<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318140050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE itinary_activity DROP FOREIGN KEY FK_2967ECD7B897C559');
        $this->addSql('ALTER TABLE itinary_activity ADD CONSTRAINT FK_2967ECD7B897C559 FOREIGN KEY (itinary_id) REFERENCES itinary (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE itinary_activity DROP FOREIGN KEY FK_2967ECD7B897C559');
        $this->addSql('ALTER TABLE itinary_activity ADD CONSTRAINT FK_2967ECD7B897C559 FOREIGN KEY (itinary_id) REFERENCES itinary (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
