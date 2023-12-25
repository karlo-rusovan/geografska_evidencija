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
