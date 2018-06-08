<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180607235635 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE head_office (id INTEGER NOT NULL, balance DOUBLE PRECISION NOT NULL, cash_one_cent_count INTEGER NOT NULL, cash_ten_cent_count INTEGER NOT NULL, cash_quarter_count INTEGER NOT NULL, cash_one_dollar_count INTEGER NOT NULL, cash_five_dollar_count INTEGER NOT NULL, cash_twenty_dollar_count INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TEMPORARY TABLE __temp__atm AS SELECT id, money_charged, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM atm');
        $this->addSql('DROP TABLE atm');
        $this->addSql('CREATE TABLE atm (id INTEGER NOT NULL, money_charged DOUBLE PRECISION NOT NULL, money_inside_one_cent_count INTEGER NOT NULL, money_inside_ten_cent_count INTEGER NOT NULL, money_inside_quarter_count INTEGER NOT NULL, money_inside_one_dollar_count INTEGER NOT NULL, money_inside_five_dollar_count INTEGER NOT NULL, money_inside_twenty_dollar_count INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO atm (id, money_charged, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count) SELECT id, money_charged, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM __temp__atm');
        $this->addSql('DROP TABLE __temp__atm');
        $this->addSql('DROP INDEX IDX_AC0E2067B0081B53');
        $this->addSql('CREATE TEMPORARY TABLE __temp__slot AS SELECT id, snack_machine_id, position, snack_pile_snack_id, snack_pile_quantity, snack_pile_price FROM slot');
        $this->addSql('DROP TABLE slot');
        $this->addSql('CREATE TABLE slot (id INTEGER NOT NULL, snack_machine_id INTEGER DEFAULT NULL, position INTEGER NOT NULL, snack_pile_snack_id INTEGER NOT NULL, snack_pile_quantity INTEGER NOT NULL, snack_pile_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_AC0E2067B0081B53 FOREIGN KEY (snack_machine_id) REFERENCES snack_machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO slot (id, snack_machine_id, position, snack_pile_snack_id, snack_pile_quantity, snack_pile_price) SELECT id, snack_machine_id, position, snack_pile_snack_id, snack_pile_quantity, snack_pile_price FROM __temp__slot');
        $this->addSql('DROP TABLE __temp__slot');
        $this->addSql('CREATE INDEX IDX_AC0E2067B0081B53 ON slot (snack_machine_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__snack AS SELECT id, name FROM snack');
        $this->addSql('DROP TABLE snack');
        $this->addSql('CREATE TABLE snack (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO snack (id, name) SELECT id, name FROM __temp__snack');
        $this->addSql('DROP TABLE __temp__snack');
        $this->addSql('CREATE TEMPORARY TABLE __temp__snack_machine AS SELECT id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count, money_in_transaction FROM snack_machine');
        $this->addSql('DROP TABLE snack_machine');
        $this->addSql('CREATE TABLE snack_machine (id INTEGER NOT NULL, money_inside_one_cent_count INTEGER NOT NULL, money_inside_ten_cent_count INTEGER NOT NULL, money_inside_quarter_count INTEGER NOT NULL, money_inside_one_dollar_count INTEGER NOT NULL, money_inside_five_dollar_count INTEGER NOT NULL, money_inside_twenty_dollar_count INTEGER NOT NULL, money_in_transaction DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO snack_machine (id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count, money_in_transaction) SELECT id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count, money_in_transaction FROM __temp__snack_machine');
        $this->addSql('DROP TABLE __temp__snack_machine');


        $this->addSql('INSERT INTO head_office(id, cash_one_cent_count, cash_ten_cent_count, cash_quarter_count, cash_one_dollar_count, cash_five_dollar_count, cash_twenty_dollar_count, balance) 
                            VALUES (1,20,20,20,20,20,20,10)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE head_office');
        $this->addSql('CREATE TEMPORARY TABLE __temp__atm AS SELECT id, money_charged, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM atm');
        $this->addSql('DROP TABLE atm');
        $this->addSql('CREATE TABLE atm (id INTEGER NOT NULL, money_charged DOUBLE PRECISION NOT NULL, money_inside_one_cent_count INTEGER NOT NULL, money_inside_ten_cent_count INTEGER NOT NULL, money_inside_quarter_count INTEGER NOT NULL, money_inside_one_dollar_count INTEGER NOT NULL, money_inside_five_dollar_count INTEGER NOT NULL, money_inside_twenty_dollar_count INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO atm (id, money_charged, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count) SELECT id, money_charged, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM __temp__atm');
        $this->addSql('DROP TABLE __temp__atm');
        $this->addSql('DROP INDEX IDX_AC0E2067B0081B53');
        $this->addSql('CREATE TEMPORARY TABLE __temp__slot AS SELECT id, snack_machine_id, position, snack_pile_snack_id, snack_pile_quantity, snack_pile_price FROM slot');
        $this->addSql('DROP TABLE slot');
        $this->addSql('CREATE TABLE slot (id INTEGER NOT NULL, snack_machine_id INTEGER DEFAULT NULL, position INTEGER NOT NULL, snack_pile_snack_id INTEGER NOT NULL, snack_pile_quantity INTEGER NOT NULL, snack_pile_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO slot (id, snack_machine_id, position, snack_pile_snack_id, snack_pile_quantity, snack_pile_price) SELECT id, snack_machine_id, position, snack_pile_snack_id, snack_pile_quantity, snack_pile_price FROM __temp__slot');
        $this->addSql('DROP TABLE __temp__slot');
        $this->addSql('CREATE INDEX IDX_AC0E2067B0081B53 ON slot (snack_machine_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__snack AS SELECT id, name FROM snack');
        $this->addSql('DROP TABLE snack');
        $this->addSql('CREATE TABLE snack (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO snack (id, name) SELECT id, name FROM __temp__snack');
        $this->addSql('DROP TABLE __temp__snack');
        $this->addSql('CREATE TEMPORARY TABLE __temp__snack_machine AS SELECT id, money_in_transaction, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM snack_machine');
        $this->addSql('DROP TABLE snack_machine');
        $this->addSql('CREATE TABLE snack_machine (id INTEGER NOT NULL, money_in_transaction DOUBLE PRECISION NOT NULL, money_inside_one_cent_count INTEGER NOT NULL, money_inside_ten_cent_count INTEGER NOT NULL, money_inside_quarter_count INTEGER NOT NULL, money_inside_one_dollar_count INTEGER NOT NULL, money_inside_five_dollar_count INTEGER NOT NULL, money_inside_twenty_dollar_count INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO snack_machine (id, money_in_transaction, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count) SELECT id, money_in_transaction, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM __temp__snack_machine');
        $this->addSql('DROP TABLE __temp__snack_machine');
    }
}
