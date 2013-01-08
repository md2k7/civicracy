-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

ALTER TABLE `tbl_category` ADD `registrationcode` VARCHAR( 128 ) NOT NULL AFTER `viewboard`
ALTER TABLE `tbl_category_history` ADD `registrationcode` VARCHAR( 128 ) NOT NULL AFTER `viewboard`
