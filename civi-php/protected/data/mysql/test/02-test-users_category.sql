-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

--DELETE FROM `tbl_user` WHERE `username` != 'admin'
--INSERT INTO `tbl_user` (`username`, `password`, `salt`, `email`, `realname`) VALUES ('user3', 'fdf28d484aebd700ec36585cc3efc481', 'LaeorSDXvM%IPQKVjr=a', 'user3@foo.bar', 'Benutzer Drei'), ('user1', '1164ca33a2ef24d38aaece4c94d3ef07', '0UUUNjpE"5fYp6W/6Nhd', 'user1@foo.bar', 'Benutzer Eins'), ('user2', '7414b9de140d14d6552f76898f3a9dab', 'Kpc4BUz(Y%Q0VYs20I2H', 'user2@foo.bar', 'Benutzer Zwei'), ('user4', '4356540b54c388d153e038c867145572', 'KoAf80gnEeVZx8P0FplP', 'user4@foo.bar', 'Benutzer Vier')
--DELETE FROM `tbl_category` WHERE `name` = 'Schulsprecher'
INSERT INTO `tbl_category` (`name`) VALUES ('Schülerrat')
