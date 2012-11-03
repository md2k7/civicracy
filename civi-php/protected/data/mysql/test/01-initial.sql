-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

--USE civi

--SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
--SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `tbl_category` ( `id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8
CREATE TABLE IF NOT EXISTS `tbl_user` ( `id` int(11) NOT NULL AUTO_INCREMENT, `username` varchar(128) NOT NULL, `password` varchar(128) NOT NULL, `salt` varchar(128) NOT NULL, `email` varchar(128) NOT NULL, `realname` varchar(128) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `username` (`username`), UNIQUE KEY `name` (`realname`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8
CREATE TABLE IF NOT EXISTS `tbl_vote` ( `category_id` int(11) NOT NULL, `voter_id` int(11) NOT NULL, `candidate_id` int(11) NOT NULL, `reason` text NOT NULL, PRIMARY KEY (`category_id`,`voter_id`), KEY `voter_id` (`voter_id`), KEY `candidate_id` (`candidate_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8
CREATE TABLE IF NOT EXISTS `tbl_parameter` ( `name` varchar(128) NOT NULL, `value` varchar(255) NOT NULL, PRIMARY KEY (`name`)) ENGINE=InnoDB DEFAULT CHARSET=utf8

ALTER TABLE `tbl_vote` ADD CONSTRAINT `tbl_vote_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`), ADD CONSTRAINT `tbl_vote_ibfk_2` FOREIGN KEY (`voter_id`) REFERENCES `tbl_user` (`id`), ADD CONSTRAINT `tbl_vote_ibfk_3` FOREIGN KEY (`candidate_id`) REFERENCES `tbl_user` (`id`)

INSERT INTO `tbl_user` (`id`, `username`, `password`, `salt`, `email`, `realname`) VALUES (1, 'admin', 'd0d5d84abe6a79d394e109f1e0898324', 'NvWe02d8VnUogM8', 'root@example.com', 'Administrator')
INSERT INTO `tbl_parameter` (`name`, `value`) VALUES ('schema_version', '1')
