<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213123843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526cb03a8386');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526c29ccbad0');
        $this->addSql('ALTER TABLE tournament DROP CONSTRAINT fk_bd5fb8d9b03a8386');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT fk_23a0e66b03a8386');
        $this->addSql('ALTER TABLE forum DROP CONSTRAINT fk_852bbecdb03a8386');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT fk_6a2ca10c7e3c61f9');
        $this->addSql('ALTER TABLE signaled_comment DROP CONSTRAINT fk_693aba496226b1ba');
        $this->addSql('ALTER TABLE signaled_comment DROP CONSTRAINT fk_693aba495a203bb0');
        $this->addSql('ALTER TABLE signaled_comment DROP CONSTRAINT fk_693aba49f8697d13');
        $this->addSql('ALTER TABLE clip DROP CONSTRAINT fk_ad201467a2b28fe8');
        $this->addSql('ALTER TABLE tournament_user DROP CONSTRAINT fk_ba1e647733d1a3e7');
        $this->addSql('ALTER TABLE tournament_user DROP CONSTRAINT fk_ba1e6477a76ed395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE signaled_comment');
        $this->addSql('DROP TABLE clip');
        $this->addSql('DROP TABLE tournament_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE comment (id UUID NOT NULL, created_by_id UUID NOT NULL, forum_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9474526c29ccbad0 ON comment (forum_id)');
        $this->addSql('CREATE INDEX idx_9474526cb03a8386 ON comment (created_by_id)');
        $this->addSql('COMMENT ON COLUMN comment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.forum_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tournament (id UUID NOT NULL, created_by_id UUID NOT NULL, max_players INT NOT NULL, is_free BOOLEAN NOT NULL, is_over BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, participation_deadline DATE NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_bd5fb8d9b03a8386 ON tournament (created_by_id)');
        $this->addSql('COMMENT ON COLUMN tournament.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tournament.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tournament.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tournament.participation_deadline IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tournament.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE article (id UUID NOT NULL, created_by_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_23a0e66b03a8386 ON article (created_by_id)');
        $this->addSql('COMMENT ON COLUMN article.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN article.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN article.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE forum (id UUID NOT NULL, created_by_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(255) NOT NULL, is_valid BOOLEAN NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_852bbecdb03a8386 ON forum (created_by_id)');
        $this->addSql('COMMENT ON COLUMN forum.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN forum.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN forum.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE media (id UUID NOT NULL, owner_id UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_6a2ca10c7e3c61f9 ON media (owner_id)');
        $this->addSql('COMMENT ON COLUMN media.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN media.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE signaled_comment (id UUID NOT NULL, signaled_by_id UUID NOT NULL, signaled_user_id UUID NOT NULL, comment_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_693aba49f8697d13 ON signaled_comment (comment_id)');
        $this->addSql('CREATE INDEX idx_693aba495a203bb0 ON signaled_comment (signaled_user_id)');
        $this->addSql('CREATE INDEX idx_693aba496226b1ba ON signaled_comment (signaled_by_id)');
        $this->addSql('COMMENT ON COLUMN signaled_comment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN signaled_comment.signaled_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN signaled_comment.signaled_user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN signaled_comment.comment_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE clip (id UUID NOT NULL, uploaded_by_id UUID NOT NULL, path VARCHAR(255) NOT NULL, is_valid BOOLEAN NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ad201467a2b28fe8 ON clip (uploaded_by_id)');
        $this->addSql('COMMENT ON COLUMN clip.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN clip.uploaded_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN clip.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tournament_user (tournament_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY(tournament_id, user_id))');
        $this->addSql('CREATE INDEX idx_ba1e6477a76ed395 ON tournament_user (user_id)');
        $this->addSql('CREATE INDEX idx_ba1e647733d1a3e7 ON tournament_user (tournament_id)');
        $this->addSql('COMMENT ON COLUMN tournament_user.tournament_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tournament_user.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526cb03a8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526c29ccbad0 FOREIGN KEY (forum_id) REFERENCES forum (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT fk_bd5fb8d9b03a8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT fk_23a0e66b03a8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT fk_852bbecdb03a8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT fk_6a2ca10c7e3c61f9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE signaled_comment ADD CONSTRAINT fk_693aba496226b1ba FOREIGN KEY (signaled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE signaled_comment ADD CONSTRAINT fk_693aba495a203bb0 FOREIGN KEY (signaled_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE signaled_comment ADD CONSTRAINT fk_693aba49f8697d13 FOREIGN KEY (comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE clip ADD CONSTRAINT fk_ad201467a2b28fe8 FOREIGN KEY (uploaded_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament_user ADD CONSTRAINT fk_ba1e647733d1a3e7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament_user ADD CONSTRAINT fk_ba1e6477a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
