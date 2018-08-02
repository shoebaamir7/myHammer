<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180802170016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO user (id, name, email, is_active, role, created_at, updated_at) VALUES (1,\'ADMIN USER\',\'admin@myhammer.de\',1,\'ADMIN\', now(),now())');
        $this->addSql('INSERT INTO user (id, name, email, is_active, role, created_at, updated_at) VALUES (2,\'END USER\',\'user@gmail.com\',1,\'USER\', now(),now())');
        $this->addSql('INSERT INTO category_type(id, title, is_active, created_at, updated_at, category_unique_id) VALUES (1,\'Sonstige Umzugsleistungen\',1,now(),now(),\'804040\')');
        $this->addSql('INSERT INTO category_type(id, title, is_active, created_at, updated_at, category_unique_id) VALUES (2,\'Abtransport, Entsorgung und Entrümpelung\',1,now(),now(),\'802030\')');
        $this->addSql('INSERT INTO category_type(id, title, is_active, created_at, updated_at, category_unique_id) VALUES (3,\'Fensterreinigung\',1,now(),now(),\'411070\')');
        $this->addSql('INSERT INTO category_type(id, title, is_active, created_at, updated_at, category_unique_id) VALUES (4,\'Holzdielen schleifen\',1,now(),now(),\'402020\')');
        $this->addSql('INSERT INTO category_type(id, title, is_active, created_at, updated_at, category_unique_id) VALUES (5,\'Kellersanierung\',1,now(),now(),\'108140\')');
        $this->addSql('INSERT INTO region(id, zip_code, city, country) VALUES (1,\'10115\',\'Berlin\',\'Germany\');');
        $this->addSql('INSERT INTO region(id, zip_code, city, country) VALUES (2,\'32457\',\'Porta Westfalica\',\'Germany\');');
        $this->addSql('INSERT INTO region(id, zip_code, city, country) VALUES (3,\'01623\',\'Lommatzsch\',\'Germany\');');
        $this->addSql('INSERT INTO region(id, zip_code, city, country) VALUES (4,\'21521\',\'Hamburg\',\'Germany\');');
        $this->addSql('INSERT INTO region(id, zip_code, city, country) VALUES (5,\'06895\',\'Bülzig\',\'Germany\');');
        $this->addSql('INSERT INTO region(id, zip_code, city, country) VALUES (6,\'01612\',\'Diesbar-Seußlitz\',\'Germany\');');
        $this->addSql('INSERT INTO job_type(id, title, is_active, created_at, updated_at) VALUES (1,\'Umzug & Transport\',1,now(),now())');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        $this->addSql('DELETE FROM user');
        $this->addSql('DELETE FROM category_type');
        $this->addSql('DELETE FROM region');
        $this->addSql('DELETE FROM job_type');
    }
}
