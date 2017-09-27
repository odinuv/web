-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `contact` (
  `id_contact` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_person` int(10) unsigned NOT NULL,
  `id_contact_type` int(10) unsigned NOT NULL,
  `contact` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_contact`),
  KEY `id_person` (`id_person`),
  KEY `id_contact_type` (`id_contact_type`),
  CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`),
  CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`id_contact_type`) REFERENCES `contact_type` (`id_contact_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `contact_type` (
  `id_contact_type` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `validation_regexp` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_contact_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `location` (
  `id_location` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `street_name` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `street_number` int(10) unsigned DEFAULT NULL,
  `zip` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `country` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `latitude` decimal(10,0) DEFAULT NULL,
  `longitude` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id_location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `meeting` (
  `id_meeting` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `duration` time DEFAULT NULL,
  `id_location` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_meeting`),
  KEY `id_location` (`id_location`),
  CONSTRAINT `meeting_ibfk_1` FOREIGN KEY (`id_location`) REFERENCES `location` (`id_location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `person` (
  `id_person` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `first_name` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `last_name` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `id_location` int(10) unsigned DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_person`),
  KEY `id_location` (`id_location`),
  CONSTRAINT `person_ibfk_1` FOREIGN KEY (`id_location`) REFERENCES `location` (`id_location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `person_meeting` (
  `id_person` int(10) unsigned NOT NULL,
  `id_meeting` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_person`,`id_meeting`),
  KEY `id_meeting` (`id_meeting`),
  CONSTRAINT `person_meeting_ibfk_1` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`),
  CONSTRAINT `person_meeting_ibfk_2` FOREIGN KEY (`id_meeting`) REFERENCES `meeting` (`id_meeting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `relation` (
  `id_relation` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_person1` int(10) unsigned NOT NULL,
  `id_person2` int(10) unsigned NOT NULL,
  `description` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `id_relation_type` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_relation`),
  KEY `id_person1` (`id_person1`),
  KEY `id_person2` (`id_person2`),
  KEY `id_relation_type` (`id_relation_type`),
  CONSTRAINT `relation_ibfk_1` FOREIGN KEY (`id_person1`) REFERENCES `person` (`id_person`),
  CONSTRAINT `relation_ibfk_2` FOREIGN KEY (`id_person2`) REFERENCES `person` (`id_person`),
  CONSTRAINT `relation_ibfk_3` FOREIGN KEY (`id_relation_type`) REFERENCES `relation_type` (`id_relation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `relation_type` (
  `id_relation_type` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_relation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2017-09-27 12:22:18
