-- MySQL Script generated by MySQL Workbench
-- Sun Apr  8 23:37:07 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
  `facebook_id` BIGINT(255) UNSIGNED NULL,
  `name` VARCHAR(60) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` TEXT NOT NULL,
  `bio` VARCHAR(255) NULL DEFAULT 'hey je suis sur Ngpictures 2.0',
  `phone` VARCHAR(45) NULL,
  `avatar` VARCHAR(500) NULL DEFAULT 'default.jpg',
  `confirmation_token` VARCHAR(75) NULL,
  `confirmed_at` DATETIME NULL,
  `reset_token` VARCHAR(75) NULL,
  `reset_at` DATETIME NULL,
  `remember_token` VARCHAR(75) NULL,
  `status` VARCHAR(45) NOT NULL DEFAULT 'users',
  `rank` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `categories` ;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(500) NOT NULL,
  `date_created` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `title_UNIQUE` ON `categories` (`title` ASC);


-- -----------------------------------------------------
-- Table `posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `posts` ;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `content` LONGTEXT NULL,
  `date_created` DATETIME NOT NULL,
  `thumb` VARCHAR(500) NOT NULL,
  `slug` VARCHAR(1000) NOT NULL,
  `online` TINYINT(4) UNSIGNED NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  `categories_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_articles_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_posts_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`))
ENGINE = InnoDB;

CREATE INDEX `fk_articles_users_idx` ON `posts` (`users_id` ASC);


-- -----------------------------------------------------
-- Table `blog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog` ;

CREATE TABLE IF NOT EXISTS `blog` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `content` LONGTEXT NULL,
  `date_created` DATETIME NOT NULL,
  `thumb` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(1000) NULL,
  `online` TINYINT(4) UNSIGNED NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  `categories_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_blog_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_blog_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `albums`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `albums` ;

CREATE TABLE IF NOT EXISTS `albums` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(500) NULL,
  `date_created` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gallery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gallery` ;

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  `tags` TEXT NULL,
  `thumb` VARCHAR(1000) NOT NULL,
  `description` TEXT NULL,
  `download` INT UNSIGNED NULL,
  `date_created` DATETIME NOT NULL,
  `online` TINYINT(4) UNSIGNED NOT NULL DEFAULT 0,
  `categories_id` INT UNSIGNED NOT NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  `albums_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_gallery_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `fk_gallery_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_gallery_albums1` FOREIGN KEY (`albums_id`) REFERENCES `albums` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tags` ;

CREATE TABLE IF NOT EXISTS `tags` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gallery_tags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gallery_tags` ;

CREATE TABLE IF NOT EXISTS `gallery_tags` (
  `gallery_id` INT UNSIGNED NOT NULL,
  `tags_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`gallery_id`, `tags_id`),
  CONSTRAINT `fk_gallery_has_tags_gallery1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`),
  CONSTRAINT `fk_gallery_has_tags_tags1` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`))
ENGINE = InnoDB;

CREATE INDEX `fk_gallery_has_tags_tags1_idx` ON `gallery_tags` (`tags_id` ASC);
CREATE INDEX `fk_gallery_has_tags_gallery1_idx` ON `gallery_tags` (`gallery_id` ASC);


-- -----------------------------------------------------
-- Table `likes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `likes` ;

CREATE TABLE IF NOT EXISTS `likes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_created` DATETIME NOT NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  `posts_id` INT UNSIGNED NOT NULL,
  `gallery_id` INT UNSIGNED NOT NULL,
  `blog_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_likes_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_likes_posts1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `fk_likes_gallery1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`),
  CONSTRAINT `fk_likes_blog1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`))
ENGINE = InnoDB;

CREATE INDEX `fk_likes_users1_idx` ON `likes` (`users_id` ASC);
CREATE INDEX `fk_likes_posts1_idx` ON `likes` (`posts_id` ASC);
CREATE INDEX `fk_likes_gallery1_idx` ON `likes` (`gallery_id` ASC);
CREATE INDEX `fk_likes_blog1_idx` ON `likes` (`blog_id` ASC);


-- -----------------------------------------------------
-- Table `comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `comments` ;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment` MEDIUMTEXT NOT NULL,
  `date_created` DATETIME NOT NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  `posts_id` INT UNSIGNED NOT NULL,
  `gallery_id` INT UNSIGNED NOT NULL,
  `blog_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_comments_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_comments_posts1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `fk_comments_gallery1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`),
  CONSTRAINT `fk_comments_blog1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`))
ENGINE = InnoDB;

CREATE INDEX `fk_comments_posts1_idx` ON `comments` (`posts_id` ASC);
CREATE INDEX `fk_comments_gallery1_idx` ON `comments` (`gallery_id` ASC);
CREATE INDEX `fk_comments_blog1_idx` ON `comments` (`blog_id` ASC);


-- -----------------------------------------------------
-- Table `verses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `verses` ;

CREATE TABLE IF NOT EXISTS `verses` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(1000) NOT NULL,
  `ref` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `online`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `online` ;

CREATE TABLE IF NOT EXISTS `online` (
  `id` INT UNSIGNED NOT NULL,
  `online_time` TIMESTAMP NOT NULL,
  `date_created` DATETIME NOT NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_online_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ideas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ideas` ;

CREATE TABLE IF NOT EXISTS `ideas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` LONGTEXT NOT NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ideas_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bugs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bugs` ;

CREATE TABLE IF NOT EXISTS `bugs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` LONGTEXT NOT NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_bugs_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `following`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `following` ;

CREATE TABLE IF NOT EXISTS `following` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `follower_id` INT NOT NULL,
  `followed_id` INT NULL,
  `date_created` DATETIME NOT NULL,
  `users_id` BIGINT(255) UNSIGNED NOT NULL,
  `users_id1` BIGINT(255) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_following_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_following_users2` FOREIGN KEY (`users_id1`) REFERENCES `users` (`id`))
ENGINE = InnoDB;

CREATE INDEX `fk_following_users1_idx` ON `following` (`users_id` ASC);
CREATE INDEX `fk_following_users2_idx` ON `following` (`users_id1` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
