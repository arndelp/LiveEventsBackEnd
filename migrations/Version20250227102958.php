<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227102958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alert (id INT NOT NULL, message1 VARCHAR(255) DEFAULT NULL, message2 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, day_id INT DEFAULT NULL, schedule_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, details LONGTEXT NOT NULL, details2 LONGTEXT NOT NULL, image_id VARCHAR(255) DEFAULT NULL, INDEX IDX_D57C02D264D218E (location_id), INDEX IDX_D57C02D29C24126 (day_id), INDEX IDX_D57C02D2A40BC2D5 (schedule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, lastname TINYTEXT DEFAULT NULL, firstname TINYTEXT DEFAULT NULL, email TINYTEXT NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, schedule VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D264D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D29C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D2A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D264D218E');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D29C24126');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D2A40BC2D5');
        $this->addSql('DROP TABLE alert');
        $this->addSql('DROP TABLE concert');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE user');
    }
}
