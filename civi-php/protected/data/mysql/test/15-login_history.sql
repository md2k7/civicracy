-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

CREATE TABLE IF NOT EXISTS `tbl_login_history` ( `id` int(11) NOT NULL AUTO_INCREMENT, `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `user_id` int(11) NOT NULL, `action` enum('LOGIN','LOGOUT') NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8
ALTER TABLE `tbl_login_history` ADD CONSTRAINT `tbl_login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`)