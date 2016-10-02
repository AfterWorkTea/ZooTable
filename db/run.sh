#!/bin/bash
mysql -u root -p$1 < ./create_db.sql
mysql -u zoo -pzoo! < ./GetZoo1.sql
mysql -u zoo -pzoo! < ./GetZoo2.sql
mysql -u zoo -pzoo! < ./GetZoo3.sql
mysql -u zoo -pzoo! < ./GetZoo4.sql
mysql -u zoo -pzoo! < ./GetZoo5.sql
mysql -u zoo -pzoo! < ./GetGroup.sql

