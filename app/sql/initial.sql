INSERT INTO `user` (`username`, `firstName`, `lastName`, `isSuperuser`, `password`) VALUES
	('admin',  'Administrator', '',      1, '$2y$10$a3mnGnSYsrEwJXt267sM9OUy9EHbg2R7yqr/HjBB0WUhks0oETxJC'),
	('jsmith', 'John',          'Smith', 0, '$2y$10$Jcuc3gxx0SS8K92Hy3WSFOjXnC1hqiXwhyFwsO4.5nCikRp/JPbIi'),
	('jdoe',   'Jenny',         'Doe',   0, '$2y$10$CjgTqSaHnBxSI75FKhf64uaTDUWzVr6d6kkIHltRZNP1YjF504B5O'),
	('kricky', 'Kendall',       'Ricky', 0, '$2y$10$HwaeYl8/.hdXdPWcfjVXxu/MrxS3GCv52MFgI54mTsFcFHxQZwv8y');

INSERT INTO `course` (`name`, `userID`) VALUES
	('1a', (SELECT `id` FROM `user` WHERE `username` = 'jsmith')),
	('1b', (SELECT `id` FROM `user` WHERE `username` = 'jdoe')),
	('1c', (SELECT `id` FROM `user` WHERE `username` = 'kricky')),
	('2a', (SELECT `id` FROM `user` WHERE `username` = 'jdoe')),
	('2b', (SELECT `id` FROM `user` WHERE `username` = 'kricky')),
	('2c', (SELECT `id` FROM `user` WHERE `username` = 'jsmith'));

INSERT INTO `lessontime` (`startTime`, `endTime`) VALUES
	('08:15:00', '09:45:00'),
	('10:05:00', '11:35:00'),
	('13:00:00', '14:30:00'),
	('14:45:00', '16:15:00');