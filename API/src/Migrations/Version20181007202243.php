<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181007202243 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE battle_field (id INT AUTO_INCREMENT NOT NULL, board_id INT NOT NULL, INDEX IDX_42CE14EAE7EC5785 (board_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE battle_field_user (battle_field_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_34D72F299046A8E6 (battle_field_id), INDEX IDX_34D72F29A76ED395 (user_id), PRIMARY KEY(battle_field_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board_position (id INT AUTO_INCREMENT NOT NULL, board_id INT NOT NULL, battle_field_id INT NOT NULL, x_coordinate INT NOT NULL, y_coordinate INT NOT NULL, has_obstacle TINYINT(1) NOT NULL, INDEX IDX_D6DBE74CE7EC5785 (board_id), INDEX IDX_D6DBE74C9046A8E6 (battle_field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tank (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, armure INT NOT NULL, health INT NOT NULL, damage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_score (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, battle_field_id INT NOT NULL, is_won TINYINT(1) NOT NULL, INDEX IDX_AA4EDEA76ED395 (user_id), INDEX IDX_AA4EDE9046A8E6 (battle_field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_action (id INT AUTO_INCREMENT NOT NULL, move_id INT DEFAULT NULL, game_score_id INT NOT NULL, name VARCHAR(255) NOT NULL, damage INT NOT NULL, INDEX IDX_3AF9215A6DC541A8 (move_id), INDEX IDX_3AF9215AB9AFF577 (game_score_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE battle_field_tank (id INT AUTO_INCREMENT NOT NULL, tank_id INT NOT NULL, battle_field_id INT DEFAULT NULL, user_id INT NOT NULL, health INT NOT NULL, armure INT NOT NULL, damage INT NOT NULL, x_coordinate INT DEFAULT NULL, y_coordinate INT DEFAULT NULL, INDEX IDX_14564E5915C652B5 (tank_id), INDEX IDX_14564E599046A8E6 (battle_field_id), INDEX IDX_14564E59A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board (id INT AUTO_INCREMENT NOT NULL, size INT NOT NULL, obstacles INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE battle_field ADD CONSTRAINT FK_42CE14EAE7EC5785 FOREIGN KEY (board_id) REFERENCES board (id)');
        $this->addSql('ALTER TABLE battle_field_user ADD CONSTRAINT FK_34D72F299046A8E6 FOREIGN KEY (battle_field_id) REFERENCES battle_field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE battle_field_user ADD CONSTRAINT FK_34D72F29A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE board_position ADD CONSTRAINT FK_D6DBE74CE7EC5785 FOREIGN KEY (board_id) REFERENCES board (id)');
        $this->addSql('ALTER TABLE board_position ADD CONSTRAINT FK_D6DBE74C9046A8E6 FOREIGN KEY (battle_field_id) REFERENCES battle_field (id)');
        $this->addSql('ALTER TABLE game_score ADD CONSTRAINT FK_AA4EDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game_score ADD CONSTRAINT FK_AA4EDE9046A8E6 FOREIGN KEY (battle_field_id) REFERENCES battle_field (id)');
        $this->addSql('ALTER TABLE game_action ADD CONSTRAINT FK_3AF9215A6DC541A8 FOREIGN KEY (move_id) REFERENCES board_position (id)');
        $this->addSql('ALTER TABLE game_action ADD CONSTRAINT FK_3AF9215AB9AFF577 FOREIGN KEY (game_score_id) REFERENCES game_score (id)');
        $this->addSql('ALTER TABLE battle_field_tank ADD CONSTRAINT FK_14564E5915C652B5 FOREIGN KEY (tank_id) REFERENCES tank (id)');
        $this->addSql('ALTER TABLE battle_field_tank ADD CONSTRAINT FK_14564E599046A8E6 FOREIGN KEY (battle_field_id) REFERENCES battle_field (id)');
        $this->addSql('ALTER TABLE battle_field_tank ADD CONSTRAINT FK_14564E59A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE battle_field_user DROP FOREIGN KEY FK_34D72F299046A8E6');
        $this->addSql('ALTER TABLE board_position DROP FOREIGN KEY FK_D6DBE74C9046A8E6');
        $this->addSql('ALTER TABLE game_score DROP FOREIGN KEY FK_AA4EDE9046A8E6');
        $this->addSql('ALTER TABLE battle_field_tank DROP FOREIGN KEY FK_14564E599046A8E6');
        $this->addSql('ALTER TABLE game_action DROP FOREIGN KEY FK_3AF9215A6DC541A8');
        $this->addSql('ALTER TABLE battle_field_tank DROP FOREIGN KEY FK_14564E5915C652B5');
        $this->addSql('ALTER TABLE battle_field_user DROP FOREIGN KEY FK_34D72F29A76ED395');
        $this->addSql('ALTER TABLE game_score DROP FOREIGN KEY FK_AA4EDEA76ED395');
        $this->addSql('ALTER TABLE battle_field_tank DROP FOREIGN KEY FK_14564E59A76ED395');
        $this->addSql('ALTER TABLE game_action DROP FOREIGN KEY FK_3AF9215AB9AFF577');
        $this->addSql('ALTER TABLE battle_field DROP FOREIGN KEY FK_42CE14EAE7EC5785');
        $this->addSql('ALTER TABLE board_position DROP FOREIGN KEY FK_D6DBE74CE7EC5785');
        $this->addSql('DROP TABLE battle_field');
        $this->addSql('DROP TABLE battle_field_user');
        $this->addSql('DROP TABLE board_position');
        $this->addSql('DROP TABLE tank');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE game_score');
        $this->addSql('DROP TABLE game_action');
        $this->addSql('DROP TABLE battle_field_tank');
        $this->addSql('DROP TABLE board');
    }
}
