<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241205172456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concert (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, day_id INT NOT NULL, schedule_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, image_id VARCHAR(255) DEFAULT NULL, details LONGTEXT DEFAULT NULL, details2 LONGTEXT DEFAULT NULL, INDEX IDX_D57C02D264D218E (location_id), INDEX IDX_D57C02D29C24126 (day_id), INDEX IDX_D57C02D2A40BC2D5 (schedule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, job_id INT DEFAULT NULL, firstname VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, age SMALLINT NOT NULL, UNIQUE INDEX UNIQ_FCEC9EFCCFA12B8 (profile_id), INDEX IDX_FCEC9EFBE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_hobby (personne_id INT NOT NULL, hobby_id INT NOT NULL, INDEX IDX_2D85E25EA21BD112 (personne_id), INDEX IDX_2D85E25E322B2123 (hobby_id), PRIMARY KEY(personne_id, hobby_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, rs VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, schedule VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D264D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D29C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D2A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE personne_hobby ADD CONSTRAINT FK_2D85E25EA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_hobby ADD CONSTRAINT FK_2D85E25E322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D264D218E');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D29C24126');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D2A40BC2D5');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFCCFA12B8');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFBE04EA9');
        $this->addSql('ALTER TABLE personne_hobby DROP FOREIGN KEY FK_2D85E25EA21BD112');
        $this->addSql('ALTER TABLE personne_hobby DROP FOREIGN KEY FK_2D85E25E322B2123');
        $this->addSql('DROP TABLE concert');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE hobby');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personne_hobby');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE schedule');
    }
}
