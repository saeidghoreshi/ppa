USE `ppatestv2`;

INSERT INTO `ppatestv2`.`passphrase`
(`user_id`,
 `passphrase_answer`,
 `passphrase_question`,
 `passphrase_clue`
)
(SELECT
    user_id,
    'Dexter',
    'What is your favourite TV show?',
    'TV Show'
FROM `ppatestv2`.`user`
WHERE user_email='steve@payphoneapp.com'
);
INSERT INTO `ppatestv2`.`passphrase`
(`user_id`,
 `passphrase_answer`,
 `passphrase_question`,
 `passphrase_clue`
)
(SELECT
    user_id,
    'Halifax West',
    'What high school did you attend?',
    'High School'
FROM `ppatestv2`.`user`
WHERE user_email='steve@payphoneapp.com'
);
