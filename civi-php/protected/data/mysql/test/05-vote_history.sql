-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons
 
CREATE TABLE IF NOT EXISTS `tbl_vote_history` (`id` int(11) NOT NULL AUTO_INCREMENT, `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `category_id` int(11) NOT NULL, `voter_id` int(11) NOT NULL, `candidate_id` int(11) NOT NULL, `reason` text NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
