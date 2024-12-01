#!/bin/bash
set -e

mysql -u root -ppassword -h localhost -e "CREATE DATABASE IF NOT EXISTS tests74;"
mysql -u root -ppassword -h localhost -e "CREATE DATABASE IF NOT EXISTS tests80;"
mysql -u root -ppassword -h localhost -e "CREATE DATABASE IF NOT EXISTS tests81;"
mysql -u root -ppassword -h localhost -e "CREATE DATABASE IF NOT EXISTS tests82;"

mysql -u root -ppassword -h localhost tests74 < /sql/areas.sql
mysql -u root -ppassword -h localhost tests74 < /sql/products.sql
mysql -u root -ppassword -h localhost tests74 < /sql/prefectures_and_cities.sql

mysql -u root -ppassword -h localhost tests80 < /sql/areas.sql
mysql -u root -ppassword -h localhost tests80 < /sql/products.sql
mysql -u root -ppassword -h localhost tests80 < /sql/prefectures_and_cities.sql

mysql -u root -ppassword -h localhost tests81 < /sql/areas.sql
mysql -u root -ppassword -h localhost tests81 < /sql/products.sql
mysql -u root -ppassword -h localhost tests81 < /sql/prefectures_and_cities.sql

mysql -u root -ppassword -h localhost tests82 < /sql/areas.sql
mysql -u root -ppassword -h localhost tests82 < /sql/products.sql
mysql -u root -ppassword -h localhost tests82 < /sql/prefectures_and_cities.sql
