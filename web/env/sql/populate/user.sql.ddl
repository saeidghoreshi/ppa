USE `ppatestv2`;

INSERT INTO `ppatestv2`.`user`
(`user_id`,
 `account_id`,
 `user_dob`,
 `user_email`,
 `user_phone`,
 `user_passcode`,
 `user_enabled`
)
VALUES
('Steve',
 'Gao',
 '1981-10-22',
 'steve@payphoneapp.com',
 '6049995920',
 MD5('1234'),
 1
),
('Noah',
 'MacNayr-Heath',
 '0000-00-00',
 'noah@payphoneapp.com',
 '',
 MD5('1234'),
 1
),
('Dmitry',
 'Dvinyaninov',
 '0000-00-00',
 'ddvinyaninov@gmail.com',
 '',
 MD5('1234'),
 1
);
