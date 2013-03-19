#!/bin/bash
echo "Create PPA tables, alter and populate with data ..."

# 1. Run create script
cd create/
./db.create.sh 184.106.95.228 ppatestv2 ppatestv2_H54f3j

# 2. Run alter tables script
#cd ../alter/
#./db.alter.sh 184.106.95.228 ppatestv2 ppatestv2_H54f3j

# 3. Run populate tables script
cd ../populate/
./db.populate.sh 184.106.95.228 ppatestv2 ppatestv2_H54f3j

echo "DB Installation Complete"
