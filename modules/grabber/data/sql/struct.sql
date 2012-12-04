CREATE TABLE IF NOT EXISTS `grabber_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `strategy` text NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `restore` tinyint(1) NOT NULL DEFAULT '1',
  `state` enum('RUNNING','DONE','IN_PROCESS') NOT NULL DEFAULT 'RUNNING',
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;