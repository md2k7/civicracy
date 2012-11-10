-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

CREATE TABLE IF NOT EXISTS `tbl_category_history` ( `id` int(11) NOT NULL AUTO_INCREMENT, `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `category_id` int(11) NOT NULL, `name` varchar(255) NOT NULL, `description` text NOT NULL, `boardsize` float NOT NULL, `active` tinyint(4) NOT NULL DEFAULT '1', PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8
ALTER TABLE `tbl_category_history` ADD CONSTRAINT `tbl_category_history_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`)