SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


DROP DATABASE IF EXISTS `ngpictures` ;
CREATE DATABASE IF NOT EXISTS `ngpictures` DEFAULT CHARACTER SET utf8 ;
USE `ngpictures` ;

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `facebook_id` BIGINT UNSIGNED NULL,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `password` TEXT NOT NULL,
  `phone` VARCHAR(25) NULL,
  `bio` VARCHAR(500) NOT NULL DEFAULT 'Hey, suis sur ngpictures 2.0',
  `avatar` VARCHAR(120) NULL DEFAULT 'default.jpg',
  `confirmation_token` VARCHAR(75) NULL,
  `confirmed_at` DATETIME NULL,
  `reset_token` VARCHAR(75) NULL,
  `reset_at` DATETIME NULL,
  `remember_token` VARCHAR(75) NULL,
  `status` CHAR(25) NOT NULL DEFAULT 'public',
  `rank` CHAR(25) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'la table qui soccupe de la gestion dles membres';


-- -----------------------------------------------------
-- Table `photographers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `photographers` ;

CREATE TABLE IF NOT EXISTS `photographers` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(120) NOT NULL,
  `location` TEXT NULL,
  `phone` VARCHAR(25) NOT NULL,
  `email` VARCHAR(60) NULL,
  `users_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_photographers_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'la table qui contient et gère les photographes';


-- -----------------------------------------------------
-- Table `locations`
-- -----------------------------------------------------
CREATE TABLE `locations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR( 60 ) NOT NULL,
  `address` VARCHAR( 80 ) NOT NULL,
  `lat` FLOAT( 10, 6 ) NOT NULL,
  `lng` FLOAT( 10, 6 ) NOT NULL,
  `type` VARCHAR( 30 ) NOT NULL DEFAULT 'Photographes',
  `photographers_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY(`id`),
  CONSTRAINT `fk_locations_photographers1` FOREIGN KEY (`photographers_id`) REFERENCES `photographers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'la table qui localise les photographes';

CREATE INDEX `fk_photographers_photographers1_idx` ON `locations` (`photographers_id` ASC);

-- -----------------------------------------------------
-- Table `verses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `verses` ;

CREATE TABLE IF NOT EXISTS `verses` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(1000) NOT NULL,
  `ref` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = MyISAM
COMMENT = 'les versets pour le module GODFIRST';


-- -----------------------------------------------------
-- Table `albums`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `albums` ;

CREATE TABLE IF NOT EXISTS `albums` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(500) NOT NULL,
  `description` TEXT NULL,
  `slug` VARCHAR(600) NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  `status` CHAR(25) NULL DEFAULT 'public',
  `online` SMALLINT(5) NOT NULL DEFAULT 1,
  `date_created` DATETIME NOT NULL,
  `photographers_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_albums_photographers1` FOREIGN KEY (`photographers_id`) REFERENCES `photographers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'les differents albums pour la galerie et les posts';

CREATE INDEX `fk_albums_photographers1_idx` ON `albums` (`photographers_id` ASC);
CREATE UNIQUE INDEX `code_UNIQUE` ON `albums` (`code` ASC);


-- -----------------------------------------------------
-- Table `categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `categories` ;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(300) NOT NULL,
  `description` TEXT NULL,
  `date_created` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'les categories pour les differents type de publication';


-- -----------------------------------------------------
-- Table `blog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog` ;

CREATE TABLE IF NOT EXISTS `blog` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(300) NOT NULL,
  `content` LONGTEXT NULL,
  `thumb` VARCHAR(500) NULL,
  `exif` TEXT NULL,
  `location` TEXT NULL,
  `color` VARCHAR(10) NULL,
  `downloads` BIGINT NOT NULL DEFAULT 0,
  `online` SMALLINT(5) NOT NULL DEFAULT 0,
  `date_created` DATETIME NULL,
  `users_id` BIGINT UNSIGNED NOT NULL DEFAULT 1,
  `categories_id` INT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_blog_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_blog_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'les articles des photographes';

CREATE INDEX `fk_blog_users1_idx` ON `blog` (`users_id` ASC);
CREATE INDEX `fk_blog_categories1_idx` ON `blog` (`categories_id` ASC);


-- -----------------------------------------------------
-- Table `bugs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bugs` ;

CREATE TABLE IF NOT EXISTS `bugs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL,
  `status` CHAR(25) NOT NULL DEFAULT 'unresolved',
  `date_created` DATETIME NULL,
  `users_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_bugs_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'bugs rencontrer sur l applicaiton par les users';

CREATE INDEX `fk_bugs_users1_idx` ON `bugs` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `ideas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ideas` ;

CREATE TABLE IF NOT EXISTS `ideas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` TEXT NULL,
  `status` CHAR(25) NOT NULL DEFAULT 'unresolved',
  `date_created` DATETIME NULL,
  `users_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ideas_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'les propositions des users pour les sites';

CREATE INDEX `fk_ideas_users1_idx` ON `ideas` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `gallery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gallery` ;

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `thumb` VARCHAR(500) NULL,
  `tags` TEXT NULL,
  `exif` TEXT NULL,
  `description` TEXT NULL,
  `slug` VARCHAR(300) NULL,
  `downloads` BIGINT NOT NULL DEFAULT 0,
  `online` SMALLINT(5) NOT NULL DEFAULT 0,
  `location` TEXT NULL,
  `color` VARCHAR(10) NULL,
  `date_created` DATETIME NULL,
  `albums_id` BIGINT UNSIGNED NOT NULL DEFAULT 1,
  `categories_id` INT UNSIGNED NOT NULL DEFAULT 1,
  `users_id` BIGINT UNSIGNED NOT NULL  DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_gallery_albums1` FOREIGN KEY (`albums_id`) REFERENCES `albums` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gallery_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gallery_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'la gallery photo';

CREATE INDEX `fk_gallery_albums1_idx` ON `gallery` (`albums_id` ASC);

CREATE INDEX `fk_gallery_categories1_idx` ON `gallery` (`categories_id` ASC);

CREATE INDEX `fk_gallery_users1_idx` ON `gallery` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `posts` ;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `slug` VARCHAR(300) NULL,
  `content` LONGTEXT NULL,
  `thumb` VARCHAR(500) NULL,
  `exif` TEXT NULL,
  `location` TEXT NULL,
  `color` VARCHAR(10) NULL,
  `downloads` BIGINT NOT NULL DEFAULT 0,
  `online` SMALLINT(5) NOT NULL DEFAULT 1,
  `date_created` DATETIME NULL,
  `categories_id` INT UNSIGNED NOT NULL DEFAULT 1,
  `users_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_posts_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_posts_users1` FOREIGN KEY (`users_id`)  REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'les publications des membres';

CREATE INDEX `fk_posts_categories1_idx` ON `posts` (`categories_id` ASC);

CREATE INDEX `fk_posts_users1_idx` ON `posts` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `comments` ;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment` TEXT NOT NULL,
  `date_created` DATETIME NULL,
  `users_id` BIGINT UNSIGNED NULL,
  `blog_id` BIGINT UNSIGNED NULL,
  `gallery_id` BIGINT UNSIGNED NULL,
  `posts_id` BIGINT UNSIGNED NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'les commentaires poster par les users';

CREATE INDEX `fk_comments_users1_idx` ON `comments` (`users_id` ASC);
CREATE INDEX `fk_comments_blog1_idx` ON `comments` (`blog_id` ASC);
CREATE INDEX `fk_comments_gallery1_idx` ON `comments` (`gallery_id` ASC);
CREATE INDEX `fk_comments_posts1_idx` ON `comments` (`posts_id` ASC);


-- -----------------------------------------------------
-- Table `following`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `following` ;

CREATE TABLE IF NOT EXISTS `following` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `follower_id` BIGINT UNSIGNED NOT NULL,
  `followed_id` BIGINT UNSIGNED NOT NULL,
  `date_created` DATETIME NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_follower_id` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_followed_id` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'module d abonnement pour les users';

CREATE INDEX `fk_follower_id_idx` ON `following` (`follower_id` ASC);
CREATE INDEX `fk_followed_id_idx` ON `following` (`followed_id` ASC);


-- -----------------------------------------------------
-- Table `likes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `likes` ;

CREATE TABLE IF NOT EXISTS `likes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_created` DATETIME NULL,
  `gallery_id` BIGINT UNSIGNED NULL,
  `blog_id` BIGINT UNSIGNED NULL,
  `posts_id` BIGINT UNSIGNED NULL,
  `users_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'enregistrement des likes pour les users';

CREATE INDEX `fk_likes_gallery1_idx` ON `likes` (`gallery_id` ASC);
CREATE INDEX `fk_likes_blog1_idx` ON `likes` (`blog_id` ASC);
CREATE INDEX `fk_likes_posts1_idx` ON `likes` (`posts_id` ASC);
CREATE INDEX `fk_likes_users1_idx` ON `likes` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `notifications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `notifications` ;

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` SMALLINT(5) UNSIGNED NOT NULL,
  `notification` TEXT NOT NULL,
  `status` SMALLINT(5) NOT NULL DEFAULT 0,
  `publication_id` BIGINT NOT NULL,
  `date_created` DATETIME NULL,
  `users_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_notifications_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'la table gere le stockage des nofication pendans un certain temps';

CREATE INDEX `fk_notifications_users1_idx` ON `notifications` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `saves`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `saves` ;

CREATE TABLE IF NOT EXISTS `saves` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_created` DATETIME NULL,
  `gallery_id` BIGINT UNSIGNED NULL,
  `blog_id` BIGINT UNSIGNED NULL,
  `posts_id` BIGINT UNSIGNED NULL,
  `users_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'les collections pour les users';

CREATE INDEX `fk_saves_gallery1_idx` ON `saves` (`gallery_id` ASC);
CREATE INDEX `fk_saves_blog1_idx` ON `saves` (`blog_id` ASC);
CREATE INDEX `fk_saves_posts1_idx` ON `saves` (`posts_id` ASC);
CREATE INDEX `fk_saves_users1_idx` ON `saves` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `online`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `online` ;

CREATE TABLE IF NOT EXISTS `online` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `online_time` TIMESTAMP NOT NULL,
  `date_created` TIMESTAMP NOT NULL,
  `users_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_online_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'les users connecter';

CREATE INDEX `fk_online_users1_idx` ON `online` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `reports`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `reports` ;

CREATE TABLE IF NOT EXISTS `reports` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` SMALLINT(5) NOT NULL,
  `content` TEXT NOT NULL,
  `publication_id` BIGINT UNSIGNED NOT NULL,
  `date_created` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'les publications signaler par les users';


-- -----------------------------------------------------
-- Table `booking`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `booking` ;

CREATE TABLE IF NOT EXISTS `booking` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(300) NOT NULL,
  `date` VARCHAR(45) NOT NULL,
  `time` VARCHAR(45) NOT NULL,
  `description` TEXT NOT NULL,
  `photographers_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_booking_photographers1` FOREIGN KEY (`photographers_id`) REFERENCES `photographers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'la table de reservation de shooting';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
