# geografska_evidencija
TBP-geografska_evidencija

Web application for logging visited cities, presenting them on a world map, and providing
statictics based on visited regions and number of cities visited each year. It also provides 
filtering based on date of visiting and city size, as well as creating accounts and different roles. 

It uses a postgis spatial database. Backup of the database is provided with the code, 
with the file name "database-backup". Connection information is provided in the 
"database.php" file, where you can find out about the database name, username and 
password used as well as port used. Database is used locally, next update to the app
will be finding a suitable Web service so the app isn't only locally hosted. 

Installation instructions:
make sure you have postgresql installed
: createdb sdb /* create a new database */
: pg_restore --dbname=sdb --no-password --format=custom --single-transaction -if-exists *path-to-backup-file* /* populate the newly created database */
: sudo apt-get install php
: sudo apt-get install php-pgql /* install pgql and php if needed */
: php -S localhost:8000 /* start a local php server */
you can now access the app in browser at localhost:8000, just make sure to change the username and password in *database.php* file
according to the user you created the database with
