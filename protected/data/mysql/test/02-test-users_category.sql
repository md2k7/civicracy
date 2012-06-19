-- use one MySQL command per line
-- comments may start at beginning of line
-- no semicolons

INSERT INTO `tbl_user` (`id`, `username`, `password`, `salt`, `email`, `realname`) VALUES (4, 'user3', 'fdf28d484aebd700ec36585cc3efc481', 'LaeorSDXvM%IPQKVjr=a', 'user3@foo.bar', 'Benutzer Drei'), (2, 'user1', '1164ca33a2ef24d38aaece4c94d3ef07', '0UUUNjpE"5fYp6W/6Nhd', 'user1@foo.bar', 'Benutzer Eins'), (3, 'user2', '7414b9de140d14d6552f76898f3a9dab', 'Kpc4BUz(Y%Q0VYs20I2H', 'user2@foo.bar', 'Benutzer Zwei'), (5, 'user4', '4356540b54c388d153e038c867145572', 'KoAf80gnEeVZx8P0FplP', 'user4@foo.bar', 'Benutzer Vier')
INSERT INTO `tbl_category` (`id`, `name`) VALUES (1, 'Schulsprecher')
