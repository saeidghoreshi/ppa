USE `ppatestv2`;

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `transaction_amount`,
# `description_merchant`,
# `description_user`,
 `transaction_paid`,
# `reason`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    10.00,
#    'Merchant Description',
#    'User Description',
    1,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    1,
    1,
    10.00,
    1,
    0,
    0,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    1,
    1,
    100.00,
    1,
    0,
    0,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    3,
    1,
    1000.00,
    1,
    0,
    0,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    2,
    1,
    55.00,
    0,
    1,
    0,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    4,
    1,
    1000.00,
    1,
    0,
    1,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    5,
    1,
    98.00,
    1,
    0,
    1,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    1,
    2,
    10.00,
    1,
    0,
    0,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    3,
    2,
    100.00,
    0,
    1,
    1,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    2,
    1,
    100.00,
    1,
    0,
    0,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    4,
    1,
    65.00,
    1,
    0,
    0,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);

INSERT INTO `ppatestv2`.`transaction`
(`user_id`,
 `merchant_id`,
 `account_id`,
 `transaction_amount`,
 `transaction_paid`,
 `transaction_cancelled`,
 `transaction_flagged`,
 `transaction_datetime_paid`
)
(SELECT
    user_id,
    4,
    2,
    200.00,
    0,
    1,
    1,
   NOW()
FROM `ppatestv2`.`user`
WHERE user_email='sxgao3001@yahoo.com'
);
