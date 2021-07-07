<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707154755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, amount NUMERIC(11, 2) NOT NULL, registration_date DATE NOT NULL, status VARCHAR(16) NOT NULL, INDEX IDX_8ECAEAD4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command_line (id INT AUTO_INCREMENT NOT NULL, command_id INT DEFAULT NULL, product_id INT DEFAULT NULL, price NUMERIC(11, 2) NOT NULL, quantity INT NOT NULL, INDEX IDX_70BE1A7B33E1689A (command_id), INDEX IDX_70BE1A7B4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notice (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT DEFAULT NULL, comment VARCHAR(1024) NOT NULL, note INT NOT NULL, registration_date DATE NOT NULL, INDEX IDX_480D45C2A76ED395 (user_id), INDEX IDX_480D45C24584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producer (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, price NUMERIC(11, 2) NOT NULL, stock INT NOT NULL, picture VARCHAR(255) NOT NULL, description VARCHAR(1024) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CDFC73564584665A (product_id), INDEX IDX_CDFC735612469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_mark (product_id INT NOT NULL, mark_id INT NOT NULL, INDEX IDX_EB9CD0D04584665A (product_id), INDEX IDX_EB9CD0D04290F12B (mark_id), PRIMARY KEY(product_id, mark_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_producer (product_id INT NOT NULL, producer_id INT NOT NULL, INDEX IDX_5CD4234B4584665A (product_id), INDEX IDX_5CD4234B89B658FE (producer_id), PRIMARY KEY(product_id, producer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_type (product_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_13675884584665A (product_id), INDEX IDX_1367588C54C8C93 (type_id), PRIMARY KEY(product_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotional_code (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, code VARCHAR(64) NOT NULL, reduction INT NOT NULL, INDEX IDX_CF002C2EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(32) NOT NULL, first_name VARCHAR(32) NOT NULL, address VARCHAR(64) NOT NULL, zip_code INT(5) UNSIGNED ZEROFILL, city VARCHAR(32) NOT NULL, phone_number VARCHAR(16) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE command_line ADD CONSTRAINT FK_70BE1A7B33E1689A FOREIGN KEY (command_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE command_line ADD CONSTRAINT FK_70BE1A7B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C24584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_mark ADD CONSTRAINT FK_EB9CD0D04584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_mark ADD CONSTRAINT FK_EB9CD0D04290F12B FOREIGN KEY (mark_id) REFERENCES mark (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_producer ADD CONSTRAINT FK_5CD4234B4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_producer ADD CONSTRAINT FK_5CD4234B89B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_type ADD CONSTRAINT FK_13675884584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_type ADD CONSTRAINT FK_1367588C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotional_code ADD CONSTRAINT FK_CF002C2EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC735612469DE2');
        $this->addSql('ALTER TABLE command_line DROP FOREIGN KEY FK_70BE1A7B33E1689A');
        $this->addSql('ALTER TABLE product_mark DROP FOREIGN KEY FK_EB9CD0D04290F12B');
        $this->addSql('ALTER TABLE product_producer DROP FOREIGN KEY FK_5CD4234B89B658FE');
        $this->addSql('ALTER TABLE command_line DROP FOREIGN KEY FK_70BE1A7B4584665A');
        $this->addSql('ALTER TABLE notice DROP FOREIGN KEY FK_480D45C24584665A');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('ALTER TABLE product_mark DROP FOREIGN KEY FK_EB9CD0D04584665A');
        $this->addSql('ALTER TABLE product_producer DROP FOREIGN KEY FK_5CD4234B4584665A');
        $this->addSql('ALTER TABLE product_type DROP FOREIGN KEY FK_13675884584665A');
        $this->addSql('ALTER TABLE product_type DROP FOREIGN KEY FK_1367588C54C8C93');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4A76ED395');
        $this->addSql('ALTER TABLE notice DROP FOREIGN KEY FK_480D45C2A76ED395');
        $this->addSql('ALTER TABLE promotional_code DROP FOREIGN KEY FK_CF002C2EA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE command_line');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE notice');
        $this->addSql('DROP TABLE producer');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_mark');
        $this->addSql('DROP TABLE product_producer');
        $this->addSql('DROP TABLE product_type');
        $this->addSql('DROP TABLE promotional_code');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
