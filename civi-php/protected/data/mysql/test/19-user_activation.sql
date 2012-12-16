-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

ALTER TABLE `tbl_user` ADD `activationcode` varchar(32)
ALTER TABLE `tbl_login_history` CHANGE `action` `action` ENUM('LOGIN', 'LOGOUT', 'ACTIVATE') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
