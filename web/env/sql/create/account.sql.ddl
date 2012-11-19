USE `ppatestv2`;

DROP TABLE IF EXISTS `ppatestv2`.`account`;
CREATE TABLE  `ppatestv2`.`account` (
  `account_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `address_id` int(10) unsigned NOT NULL,
  `account_enabled` int(1) unsigned NOT NULL default 0,
  `account_type` int(2) NOT NULL default 0,
  `account_name` varchar(30) NOT NULL default '',
  `account_firstname` varchar(50) NOT NULL default '',
  `account_lastname` varchar(50) NOT NULL default '',
  `account_prefix` varchar(10) NOT NULL default '',
  `account_number` varchar(20) NOT NULL default '',
  # Bank Account specific fields
  `account_transit` varchar(5) NOT NULL default 0,
  `account_institution` varchar(5) NOT NULL default 0,
  # Credit Card Account specific fields
  `account_expiry` date NOT NULL default '0000-00-00',
  `account_security_number` varchar(5) NOT NULL default '',
  PRIMARY KEY (`account_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`)
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE utf8_general_ci
;
