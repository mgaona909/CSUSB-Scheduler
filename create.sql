USE b18_20197884_csusb;

SET FOREIGN_KEY_CHECKS=0;

drop table googleUsers;

CREATE TABLE IF NOT EXISTS `googleUsers` (
    `googleID`  varchar(500) PRIMARY KEY NOT NULL,
    `fname`     varchar(20),
    `lname`     varchar(20),
    `email`     varchar(50),
    `account`   varchar(20)
);

drop table events;

CREATE TABLE IF NOT EXISTS `events` (
    `eventID`       int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id`            varchar(500) NOT NULL,
    `title`         varchar(255) NOT NULL,
    `eventType`     varchar(50),
    `description`   varchar(255),
    `color`         varchar(255),
    `class`         varchar(50),
    `start`         datetime NOT NULL,
    `end`           datetime DEFAULT NULL
) AUTO_INCREMENT=1;

drop table enrollment;

CREATE TABLE IF NOT EXISTS `enrollment` (
    `studentid` varchar(500) NOT NULL,
    `classID` int(11),
    FOREIGN KEY (classID) REFERENCES classes(classID),
    FOREIGN KEY (studentid) REFERENCES googleUsers(googleID)
);

drop table classes;

CREATE TABLE IF NOT EXISTS `classes` (
    `classID`       int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `facultyid`     varchar(500) NOT NULL,
    `department`    varchar(20) NOT NULL,
    `course`        varchar(20) NOT NULL,
    `instructor`    varchar(50) NOT NULL,
    `session`       varchar(20)
) AUTO_INCREMENT=1;