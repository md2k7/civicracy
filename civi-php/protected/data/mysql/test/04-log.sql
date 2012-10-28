-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

CREATE TABLE IF NOT EXISTS `tbl_log` (`id` int(11) NOT NULL AUTO_INCREMENT, `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `category` varchar(128) NOT NULL, `log` text NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
