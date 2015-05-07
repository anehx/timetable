-- Create database (drop it if it's already there)
DROP DATABASE IF EXISTS timetable;
CREATE DATABASE timetable;

-- Create user (drop it if it's already there)
GRANT ALL ON timetable.* TO 'timetable'@'localhost' IDENTIFIED BY '123qwe';
FLUSH PRIVILEGES;
