USE `ppatestv2`;

DROP TABLE IF EXISTS `ppatestv2`.`passphrase`;
CREATE TABLE  `ppatestv2`.`passphrase` (
  `passphrase_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `passphrase_answer` varchar(50) NOT NULL default '',
  `passphrase_question` varchar(50) NOT NULL default '',
  `passphrase_clue` varchar(50) default '',
  PRIMARY KEY  (`passphrase_id`),
  UNIQUE KEY `uniq` (`user_id`,`passphrase_question`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE utf8_general_ci
;
