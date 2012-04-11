#!/bin/bash

echo "clean all tables"
mysql -h $1 -u $2 --password=$3 < ./clean.sql.ddl

echo "populating user table"
mysql -h $1 -u $2 --password=$3 < ./user.sql.ddl

echo "populating address table"
mysql -h $1 -u $2 --password=$3 < ./address.sql.ddl

echo "populating passphrase table"
mysql -h $1 -u $2 --password=$3 < ./passphrase.sql.ddl
