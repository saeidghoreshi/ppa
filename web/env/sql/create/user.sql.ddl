USE `ppatestv2`;

DROP TABLE IF EXISTS `ppatestv2`.`user`;
CREATE TABLE  `ppatestv2`.`user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `user_firstname` varchar(50) NOT NULL default '',
  `user_lastname` varchar(50) NOT NULL default '',
  `user_prefix` varchar(10) NOT NULL default '',
  `user_dob` date NOT NULL default '0000-00-00',
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_passcode` varchar(50) NOT NULL default '',
  `user_enabled` int(1) NOT NULL default '0',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `unique` (`user_email`,`user_phone`)
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE utf8_general_ci
;
