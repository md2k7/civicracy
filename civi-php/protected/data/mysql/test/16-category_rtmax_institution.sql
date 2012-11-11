-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

ALTER TABLE `tbl_category` ADD `rmax` FLOAT NOT NULL DEFAULT '0.3' AFTER `boardsize`
ALTER TABLE `tbl_category` ADD `tmax` FLOAT NOT NULL DEFAULT '0.001' AFTER `rmax`
ALTER TABLE `tbl_category` ADD `institution` VARCHAR( 255 ) NOT NULL AFTER `description`

ALTER TABLE `tbl_category_history` ADD `rmax` FLOAT NOT NULL DEFAULT '0.3' AFTER `boardsize`
ALTER TABLE `tbl_category_history` ADD `tmax` FLOAT NOT NULL DEFAULT '0.001' AFTER `rmax`
ALTER TABLE `tbl_category_history` ADD `institution` VARCHAR( 255 ) NOT NULL AFTER `description`
