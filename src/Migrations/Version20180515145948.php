<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180515145948 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE slot (id INTEGER NOT NULL, snack_machine_id INTEGER DEFAULT NULL, position INTEGER NOT NULL, snack_pile_quantity INTEGER NOT NULL, snack_pile_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC0E2067B0081B53 ON slot (snack_machine_id)');
        $this->addSql('CREATE TABLE snack (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TEMPORARY TABLE __temp__snack_machine AS SELECT id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM snack_machine');
        $this->addSql('DROP TABLE snack_machine');
        $this->addSql('CREATE TABLE snack_machine (id INTEGER NOT NULL, money_inside_one_cent_count INTEGER NOT NULL, money_inside_ten_cent_count INTEGER NOT NULL, money_inside_quarter_count INTEGER NOT NULL, money_inside_one_dollar_count INTEGER NOT NULL, money_inside_five_dollar_count INTEGER NOT NULL, money_inside_twenty_dollar_count INTEGER NOT NULL, money_in_transaction DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO snack_machine (id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count) SELECT id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM __temp__snack_machine');
        $this->addSql('DROP TABLE __temp__snack_machine');

        $this->addSql("INSERT INTO snack(id, name) VALUES (1, 'Chocolate'), (2, 'Soda'), (3, 'Gum')");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE slot');
        $this->addSql('DROP TABLE snack');
        $this->addSql('CREATE TEMPORARY TABLE __temp__snack_machine AS SELECT id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM snack_machine');
        $this->addSql('DROP TABLE snack_machine');
        $this->addSql('CREATE TABLE snack_machine (id INTEGER NOT NULL, money_inside_one_cent_count INTEGER NOT NULL, money_inside_ten_cent_count INTEGER NOT NULL, money_inside_quarter_count INTEGER NOT NULL, money_inside_one_dollar_count INTEGER NOT NULL, money_inside_five_dollar_count INTEGER NOT NULL, money_inside_twenty_dollar_count INTEGER NOT NULL, money_in_transaction_one_cent_count INTEGER NOT NULL, money_in_transaction_ten_cent_count INTEGER NOT NULL, money_in_transaction_quarter_count INTEGER NOT NULL, money_in_transaction_one_dollar_count INTEGER NOT NULL, money_in_transaction_five_dollar_count INTEGER NOT NULL, money_in_transaction_twenty_dollar_count INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO snack_machine (id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count) SELECT id, money_inside_one_cent_count, money_inside_ten_cent_count, money_inside_quarter_count, money_inside_one_dollar_count, money_inside_five_dollar_count, money_inside_twenty_dollar_count FROM __temp__snack_machine');
        $this->addSql('DROP TABLE __temp__snack_machine');
    }
}
