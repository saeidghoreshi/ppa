USE `ppatestv2`;

DROP TABLE IF EXISTS `ppatestv2`.`address`;
CREATE TABLE  `ppatestv2`.`address` (
  `address_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `device_id` varchar(100) NOT NULL default '',
  `address_street` varchar(100) NOT NULL default '',
  `address_city` varchar(100) NOT NULL default '',
  `address_state` varchar(100) NOT NULL default '',
  `address_zip` varchar(100) NOT NULL default '',
  `address_country` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`address_id`),
  UNIQUE KEY `uniq` (`user_id`,`device_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE utf8_general_ci
;
