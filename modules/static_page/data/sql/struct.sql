CREATE TABLE `static_pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_name` text NOT NULL,
  `url` text NOT NULL,  
  `page_content` text,
  `seo_page_title` text,
  `seo_page_description` text,
  `seo_page_keywords` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;