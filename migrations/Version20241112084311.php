<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241112084311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE episode_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE language_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_subscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subscription_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE watch_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(100) NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category_media (category_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(category_id, media_id))');
        $this->addSql('CREATE INDEX IDX_821FEE4512469DE2 ON category_media (category_id)');
        $this->addSql('CREATE INDEX IDX_821FEE45EA9FDD75 ON category_media (media_id)');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, author_id INT DEFAULT NULL, media_id INT DEFAULT NULL, child_comment_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526CEA9FDD75 ON comment (media_id)');
        $this->addSql('CREATE INDEX IDX_9474526C1CB68378 ON comment (child_comment_id)');
        $this->addSql('COMMENT ON COLUMN comment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE episode (id INT NOT NULL, season_id INT NOT NULL, title VARCHAR(255) NOT NULL, duration TIME(0) WITHOUT TIME ZONE NOT NULL, release_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA4EC001D1 ON episode (season_id)');
        $this->addSql('CREATE TABLE language (id INT NOT NULL, name VARCHAR(100) NOT NULL, code VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE language_media (language_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(language_id, media_id))');
        $this->addSql('CREATE INDEX IDX_1574A55D82F1BAF4 ON language_media (language_id)');
        $this->addSql('CREATE INDEX IDX_1574A55DEA9FDD75 ON language_media (media_id)');
        $this->addSql('CREATE TABLE media (id INT NOT NULL, playlist_media_id INT DEFAULT NULL, watch_history_id INT DEFAULT NULL, media_type VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, short_description TEXT DEFAULT NULL, long_description TEXT DEFAULT NULL, release_date DATE NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, staff JSON NOT NULL, nominate JSON DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6A2CA10C17421B18 ON media (playlist_media_id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C4D8CCBCC ON media (watch_history_id)');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE playlist (id INT NOT NULL, creator_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D782112D61220EA6 ON playlist (creator_id)');
        $this->addSql('COMMENT ON COLUMN playlist.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN playlist.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE playlist_media (id INT NOT NULL, playlist_id INT DEFAULT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C930B84F6BBD148 ON playlist_media (playlist_id)');
        $this->addSql('CREATE TABLE playlist_subscription (id INT NOT NULL, playlist_id INT NOT NULL, subscriber_id INT NOT NULL, subscribed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_832940C6BBD148 ON playlist_subscription (playlist_id)');
        $this->addSql('CREATE INDEX IDX_832940C7808B1AD ON playlist_subscription (subscriber_id)');
        $this->addSql('CREATE TABLE season (id INT NOT NULL, serie_id INT DEFAULT NULL, season_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0E45BA9D94388BD ON season (serie_id)');
        $this->addSql('CREATE TABLE serie (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subscription (id INT NOT NULL, subscription_history_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, duration_in_months INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3C664D3DCE0C437 ON subscription (subscription_history_id)');
        $this->addSql('COMMENT ON COLUMN subscription.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE subscription_history (id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, subscription_id INT DEFAULT NULL, subscription_history_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D6499A1887DC ON "user" (subscription_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649DCE0C437 ON "user" (subscription_history_id)');
        $this->addSql('CREATE TABLE watch_history (id INT NOT NULL, customer_id INT NOT NULL, last_watched TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, number_of_views INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DE44EFD89395C3F3 ON watch_history (customer_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE category_media ADD CONSTRAINT FK_821FEE4512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_media ADD CONSTRAINT FK_821FEE45EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1CB68378 FOREIGN KEY (child_comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE language_media ADD CONSTRAINT FK_1574A55D82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE language_media ADD CONSTRAINT FK_1574A55DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C17421B18 FOREIGN KEY (playlist_media_id) REFERENCES playlist_media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4D8CCBCC FOREIGN KEY (watch_history_id) REFERENCES watch_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FBF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D61220EA6 FOREIGN KEY (creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84F6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C7808B1AD FOREIGN KEY (subscriber_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334BF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3DCE0C437 FOREIGN KEY (subscription_history_id) REFERENCES subscription_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6499A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649DCE0C437 FOREIGN KEY (subscription_history_id) REFERENCES subscription_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD89395C3F3 FOREIGN KEY (customer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE episode_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE language_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_subscription_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE season_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subscription_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subscription_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE watch_history_id_seq CASCADE');
        $this->addSql('ALTER TABLE category_media DROP CONSTRAINT FK_821FEE4512469DE2');
        $this->addSql('ALTER TABLE category_media DROP CONSTRAINT FK_821FEE45EA9FDD75');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CEA9FDD75');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C1CB68378');
        $this->addSql('ALTER TABLE episode DROP CONSTRAINT FK_DDAA1CDA4EC001D1');
        $this->addSql('ALTER TABLE language_media DROP CONSTRAINT FK_1574A55D82F1BAF4');
        $this->addSql('ALTER TABLE language_media DROP CONSTRAINT FK_1574A55DEA9FDD75');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C17421B18');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C4D8CCBCC');
        $this->addSql('ALTER TABLE movie DROP CONSTRAINT FK_1D5EF26FBF396750');
        $this->addSql('ALTER TABLE playlist DROP CONSTRAINT FK_D782112D61220EA6');
        $this->addSql('ALTER TABLE playlist_media DROP CONSTRAINT FK_C930B84F6BBD148');
        $this->addSql('ALTER TABLE playlist_subscription DROP CONSTRAINT FK_832940C6BBD148');
        $this->addSql('ALTER TABLE playlist_subscription DROP CONSTRAINT FK_832940C7808B1AD');
        $this->addSql('ALTER TABLE season DROP CONSTRAINT FK_F0E45BA9D94388BD');
        $this->addSql('ALTER TABLE serie DROP CONSTRAINT FK_AA3A9334BF396750');
        $this->addSql('ALTER TABLE subscription DROP CONSTRAINT FK_A3C664D3DCE0C437');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6499A1887DC');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649DCE0C437');
        $this->addSql('ALTER TABLE watch_history DROP CONSTRAINT FK_DE44EFD89395C3F3');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_media');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE language_media');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_media');
        $this->addSql('DROP TABLE playlist_subscription');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_history');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE watch_history');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
