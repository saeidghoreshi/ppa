USE `ppatestv2`;

DROP TABLE IF EXISTS `ppatestv2`.`transaction`;
CREATE TABLE  `ppatestv2`.`transaction` (
  `transaction_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `merchant_note` varchar(255) NOT NULL default '',
  `user_note` varchar(255) NOT NULL default '',
  `paid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `flagged` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cancelled_reason` varchar(100) DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `datetime_requested` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `datetime_paid` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `location` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`),
  FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`)
)
#ENGINE = InnoDB
ENGINE=MyISAM
CHARACTER SET = utf8
COLLATE utf8_general_ci
;
