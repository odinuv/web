CREATE TABLE `account` (
  `id_account` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;