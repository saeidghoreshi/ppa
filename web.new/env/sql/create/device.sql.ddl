USE `ppatestv2`;

DROP TABLE IF EXISTS `ppatestv2`.`device`;
CREATE TABLE  `ppatestv2`.`device` (
  `device_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `device_udid` varchar(30) NOT NULL default '',
  `device_imei` varchar(30) NOT NULL default '',
  `device_phone` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`device_id`),
  KEY `udid` (`device_udid`),
  KEY `user_id` (`user_id`),
  KEY `imei` (`device_imei`)
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE utf8_general_ci
;
