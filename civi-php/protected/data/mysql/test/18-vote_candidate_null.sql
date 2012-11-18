-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

-- enable NULL on candidate_id to indicate user abstains from voting

ALTER TABLE `tbl_vote` CHANGE `candidate_id` `candidate_id` INT( 11 ) NULL
ALTER TABLE `tbl_vote_history` CHANGE `candidate_id` `candidate_id` INT( 11 ) NULL
