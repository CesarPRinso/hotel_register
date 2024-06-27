<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627132521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE guest_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hotel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE registration_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE guest (id INT NOT NULL, registration_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, date_of_birth TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, gender VARCHAR(1) NOT NULL, passport_number VARCHAR(50) NOT NULL, country VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ACB79A35833D8F43 ON guest (registration_id)');
        $this->addSql('CREATE TABLE hotel (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE registration (id INT NOT NULL, hotel_id VARCHAR(255) NOT NULL, guest_id INT NOT NULL, check_in_date DATE NOT NULL, check_out_date DATE NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62A8A7A73243BB18 ON registration (hotel_id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A79A4AA658 ON registration (guest_id)');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A35833D8F43 FOREIGN KEY (registration_id) REFERENCES registration (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A73243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A79A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE guest_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hotel_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE registration_id_seq CASCADE');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A35833D8F43');
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT FK_62A8A7A73243BB18');
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT FK_62A8A7A79A4AA658');
        $this->addSql('DROP TABLE guest');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE registration');
    }
}
