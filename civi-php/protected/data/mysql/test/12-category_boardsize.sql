-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

ALTER TABLE `tbl_category` ADD `boardsize` TINYINT NOT NULL AFTER `description`
UPDATE `civi`.`tbl_category` SET `boardsize` = '10'