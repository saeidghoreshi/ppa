#!/bin/bash

echo "creating ppatestv2 database"
mysql -h $1 -u $2 --password=$3 < ./db.sql.ddl

echo "creating user table"
mysql -h $1 -u $2 --password=$3 < ./user.sql.ddl

echo "creating passphrase table"
mysql -h $1 -u $2 --password=$3 < ./passphrase.sql.ddl

echo "creating address table"
mysql -h $1 -u $2 --password=$3 < ./address.sql.ddl

echo "creating transaction table"
mysql -h $1 -u $2 --password=$3 < ./transaction.sql.ddl

echo "creating device table"
mysql -h $1 -u $2 --password=$3 < ./device.sql.ddl
