CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `isSuperuser` tinyint(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE  `lection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `weekday` tinyint(1) NOT NULL,
  `lectionTimeID` int(11) NOT NULL, 
  `courseID` int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE  `lectiontime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startTime` TIME NOT NULL,
  `endTime` TIME NOT NULL
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `course` ADD CONSTRAINT `course_user` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `lection` ADD CONSTRAINT `lection_course` FOREIGN KEY (`courseID`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `lection` ADD CONSTRAINT `lection_lectiontime` FOREIGN KEY (`lectionTimeID`) REFERENCES `lecitontime` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;