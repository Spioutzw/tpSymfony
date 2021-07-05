<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705174716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bien (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT NOT NULL, type_id INT NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_45EDC38676C50E4A (proprietaire_id), INDEX IDX_45EDC386C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, telephone VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, accord TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facturation (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, date_facturation DATE NOT NULL, numÃero_identification INT NOT NULL, INDEX IDX_17EB513A19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_facturation (id INT AUTO_INCREMENT NOT NULL, facture_id INT DEFAULT NULL, libelle VARCHAR(150) NOT NULL, prix DOUBLE PRECISION NOT NULL, reference INT NOT NULL, INDEX IDX_740E910D7F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, client_id INT NOT NULL, date_arrive DATE NOT NULL, date_depart DATE NOT NULL, nbr_jour_piscine_adulte INT NOT NULL, nbr_jour_piscine_enfant INT NOT NULL, nbr_enfant INT NOT NULL, nbr_adulte INT NOT NULL, INDEX IDX_5E9E89CBBD95B80F (bien_id), INDEX IDX_5E9E89CB19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proprietaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, pass VARCHAR(150) NOT NULL, role TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bien (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(150) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC38676C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC386C54C8C93 FOREIGN KEY (type_id) REFERENCES type_bien (id)');
        $this->addSql('ALTER TABLE facturation ADD CONSTRAINT FK_17EB513A19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE ligne_facturation ADD CONSTRAINT FK_740E910D7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facturation (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBBD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBBD95B80F');
        $this->addSql('ALTER TABLE facturation DROP FOREIGN KEY FK_17EB513A19EB6921');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB19EB6921');
        $this->addSql('ALTER TABLE ligne_facturation DROP FOREIGN KEY FK_740E910D7F2DEE08');
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC38676C50E4A');
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC386C54C8C93');
        $this->addSql('DROP TABLE bien');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE facturation');
        $this->addSql('DROP TABLE ligne_facturation');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE proprietaire');
        $this->addSql('DROP TABLE type_bien');
    }
}
