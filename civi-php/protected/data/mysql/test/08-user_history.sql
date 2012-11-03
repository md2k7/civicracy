-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

CREATE TABLE IF NOT EXISTS `tbl_user_history` ( `id` int(11) NOT NULL AUTO_INCREMENT, `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `user_id` int(11) NOT NULL, `username` varchar(128) NOT NULL, `password` varchar(128) NOT NULL, `salt` varchar(128) NOT NULL, `email` varchar(128) NOT NULL, `realname` varchar(128) NOT NULL, `slogan` text NOT NULL, `active` tinyint(4) NOT NULL DEFAULT '1', PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8
ALTER TABLE `tbl_user_history` ADD CONSTRAINT `tbl_user_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`)

-- add forgotten foreign key constraints for tbl_vote_history
ALTER TABLE `tbl_vote_history` ADD CONSTRAINT `tbl_vote_history_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`), ADD CONSTRAINT `tbl_vote_history_ibfk_2` FOREIGN KEY (`voter_id`) REFERENCES `tbl_user` (`id`), ADD CONSTRAINT `tbl_vote_history_ibfk_3` FOREIGN KEY (`candidate_id`) REFERENCES `tbl_user` (`id`)
