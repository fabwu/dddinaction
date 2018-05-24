<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180502180448 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE snack_machine (id INTEGER NOT NULL, money_in_transaction_one_cent_count INTEGER NOT NULL, money_in_transaction_ten_cent_count INTEGER NOT NULL, money_in_transaction_quarter_count INTEGER NOT NULL, money_in_transaction_one_dollar_count INTEGER NOT NULL, money_in_transaction_five_dollar_count INTEGER NOT NULL, money_in_transaction_twenty_dollar_count INTEGER NOT NULL, money_inside_one_cent_count INTEGER NOT NULL, money_inside_ten_cent_count INTEGER NOT NULL, money_inside_quarter_count INTEGER NOT NULL, money_inside_one_dollar_count INTEGER NOT NULL, money_inside_five_dollar_count INTEGER NOT NULL, money_inside_twenty_dollar_count INTEGER NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE snack_machine');
    }
}
