-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

ALTER TABLE `tbl_category` ADD `viewboard` BOOLEAN NOT NULL DEFAULT FALSE AFTER `tmax` 
ALTER TABLE `tbl_category_history` ADD `viewboard` BOOLEAN NOT NULL DEFAULT FALSE AFTER `tmax` 