mysql> create database company_trips;
Query OK, 1 row affected (0.03 sec)

mysql> use company_trips;
Database changed
mysql> CREATE TABLE Employee (
    -> empCode INT AUTO_INCREMENT PRIMARY KEY,
    -> name VARCHAR(50) NOT NULL,
    -> position VARCHAR(50) NOT NULL,
    -> username VARCHAR(50) NOT NULL UNIQUE,
    -> pwd VARCHAR(255) NOT NULL
    -> );
Query OK, 0 rows affected (0.10 sec)

mysql> CREATE TABLE Transport (
    -> transCode INT AUTO_INCREMENT PRIMARY KEY,
    -> type VARCHAR(50) NOT NULL,
    -> speed INT NOT NULL,
    -> capacity INT NOT NULL
    -> );
Query OK, 0 rows affected (0.04 sec)

mysql> CREATE TABLE TripDescription (
    -> descCode INT AUTO_INCREMENT PRIMARY KEY,
    -> description VARCHAR(255) NOT NULL,
    -> departureCity VARCHAR(50) NOT NULL,
    -> arrivalCity VARCHAR(50) NOT NULL
    -> );
Query OK, 0 rows affected (0.03 sec)

mysql> CREATE TABLE Trip (
    -> tripCode INT AUTO_INCREMENT PRIMARY KEY,
    -> transCode INT,
    -> descCode INT,
    -> ticketPrice DECIMAL(10, 2) NOT NULL,
    -> duration INT NOT NULL,
    -> departureTime TIME NOT NULL,
    -> FOREIGN KEY (transCode) REFERENCES Transport(transCode),
    -> FOREIGN KEY (descCode) REFERENCES TripDescription(descCode)
    -> );
Query OK, 0 rows affected (0.11 sec)

mysql> CREATE TABLE Registration (
    -> regCode INT AUTO_INCREMENT PRIMARY KEY,
    -> empCode INT,
    -> tripCode INT,
    -> numPeople INT NOT NULL,
    -> tripDate DATE NOT NULL,
    -> FOREIGN KEY (empCode) REFERENCES Employee(empCode),
    -> FOREIGN KEY (tripCode) REFERENCES Trip(tripCode)
    -> );
Query OK, 0 rows affected (0.09 sec)

mysql> show tables;
+-------------------------+
| Tables_in_company_trips |
+-------------------------+
| employee                |
| registration            |
| transport               |
| trip                    |
| tripdescription         |
+-------------------------+
5 rows in set (0.06 sec)

mysql>
