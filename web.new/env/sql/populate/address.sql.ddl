USE `ppatestv2`;

INSERT INTO `ppatestv2`.`address`
(`user_id`,
 `address_street`,
 `address_city`,
 `address_state`,
 `address_zip`,
 `address_country`
)
(SELECT
    user_id,
    '1238 Burrard Street',
    'Vancouver',
    'British Columbia',
    'V6Z3E1',
    'Canada'
FROM `ppatestv2`.`user`
WHERE user_email='steve@payphoneapp.com'
);
