-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema jdibase
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `fos_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(180) CHARACTER SET 'utf8' NOT NULL,
  `username_canonical` VARCHAR(180) CHARACTER SET 'utf8' NOT NULL,
  `email` VARCHAR(180) CHARACTER SET 'utf8' NOT NULL,
  `email_canonical` VARCHAR(180) CHARACTER SET 'utf8' NOT NULL,
  `enabled` TINYINT(1) NOT NULL,
  `salt` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `password` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL,
  `last_login` DATETIME NULL DEFAULT NULL,
  `confirmation_token` VARCHAR(180) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `password_requested_at` DATETIME NULL DEFAULT NULL,
  `roles` LONGTEXT CHARACTER SET 'utf8' NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `UNIQ_957A647992FC23A8` (`username_canonical` ASC),
  UNIQUE INDEX `UNIQ_957A6479A0D96FBF` (`email_canonical` ASC),
  UNIQUE INDEX `UNIQ_957A6479C05FB297` (`confirmation_token` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `message` (
  `idmessage` INT(11) NOT NULL AUTO_INCREMENT,
  `message` LONGTEXT NOT NULL,
  `subject` LONGTEXT NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`idmessage`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `message_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `message_user` (
  `idmessage` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `read` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idmessage`, `user_id`),
  INDEX `fk_message_has_fos_user_fos_user1_idx` (`user_id` ASC),
  INDEX `fk_message_has_fos_user_message1_idx` (`idmessage` ASC),
  CONSTRAINT `fk_message_has_fos_user_fos_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `fos_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_has_fos_user_message1`
    FOREIGN KEY (`idmessage`)
    REFERENCES `message` (`idmessage`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `priority`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `priority` (
  `idpriority` INT(11) NOT NULL AUTO_INCREMENT,
  `code` INT(11) NOT NULL,
  `libelle` VARCHAR(255) NOT NULL,
  `color` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idpriority`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project` (
  `idproject` INT(11) NOT NULL AUTO_INCREMENT,
  `libelle` VARCHAR(255) NOT NULL,
  `creationdate` DATETIME NOT NULL,
  `limitedate` DATETIME NULL DEFAULT NULL,
  `enddate` DATETIME NULL DEFAULT NULL,
  `master` INT(11) NOT NULL,
  `priorityid` INT(11) NOT NULL,
  PRIMARY KEY (`idproject`),
  INDEX `fk_project_fos_user1_idx` (`master` ASC),
  INDEX `fk_project_priority1_idx` (`priorityid` ASC),
  CONSTRAINT `fk_project_fos_user1`
    FOREIGN KEY (`master`)
    REFERENCES `fos_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_priority1`
    FOREIGN KEY (`priorityid`)
    REFERENCES `priority` (`idpriority`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_user` (
  `idproject` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`idproject`, `user_id`),
  INDEX `fk_project_has_fos_user_fos_user1_idx` (`user_id` ASC),
  INDEX `fk_project_has_fos_user_project1_idx` (`idproject` ASC),
  CONSTRAINT `fk_project_has_fos_user_fos_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `fos_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_has_fos_user_project1`
    FOREIGN KEY (`idproject`)
    REFERENCES `project` (`idproject`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task` (
  `idtask` INT(11) NOT NULL AUTO_INCREMENT,
  `libelle` VARCHAR(255) NOT NULL,
  `creationdate` DATETIME NOT NULL,
  `limitedate` DATETIME NULL DEFAULT NULL,
  `enddate` DATETIME NULL DEFAULT NULL,
  `projectmaster` INT(11) NULL DEFAULT NULL,
  `usermaster` INT(11) NULL DEFAULT NULL,
  `priorityid` INT(11) NOT NULL,
  PRIMARY KEY (`idtask`),
  INDEX `fk_task_project_idx` (`projectmaster` ASC),
  INDEX `fk_task_fos_user1_idx` (`usermaster` ASC),
  INDEX `fk_task_priority1_idx` (`priorityid` ASC),
  CONSTRAINT `fk_task_fos_user1`
    FOREIGN KEY (`usermaster`)
    REFERENCES `fos_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_priority1`
    FOREIGN KEY (`priorityid`)
    REFERENCES `priority` (`idpriority`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_project`
    FOREIGN KEY (`projectmaster`)
    REFERENCES `project` (`idproject`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `task_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_user` (
  `task_idtask` INT(11) NOT NULL AUTO_INCREMENT,
  `fos_user_id` INT(11) NOT NULL,
  PRIMARY KEY (`task_idtask`, `fos_user_id`),
  INDEX `fk_task_has_fos_user_fos_user1_idx` (`fos_user_id` ASC),
  INDEX `fk_task_has_fos_user_task1_idx` (`task_idtask` ASC),
  CONSTRAINT `fk_task_has_fos_user_fos_user1`
    FOREIGN KEY (`fos_user_id`)
    REFERENCES `fos_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_has_fos_user_task1`
    FOREIGN KEY (`task_idtask`)
    REFERENCES `task` (`idtask`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
