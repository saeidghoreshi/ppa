USE `ppatestv2`;

# Make sure to remove rows in order that does not violate foreign key
# dependencies
DELETE FROM `ppatestv2`.`passphrase`;
DELETE FROM `ppatestv2`.`address`;
DELETE FROM `ppatestv2`.`user`;
