CREATE TABLE IF NOT EXISTS `downloader_proxies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `proxy` varchar(255) DEFAULT NULL,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;