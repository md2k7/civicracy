-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

-- phpass stores salt into password hash field as well
ALTER TABLE `tbl_user` DROP `salt`;

-- reset admin password
UPDATE `tbl_user` SET `password` = '$2a$08$MWgHI6u/vHIFhmegKWnEN.BmDbwYc/GFGb58eUGx0cxXxTBDGfWCO' WHERE `username` = 'admin'
