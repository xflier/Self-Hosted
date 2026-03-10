CREATE DATABASE onlyoffice_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER '<onlyoffice user login in .env>'@'%' IDENTIFIED BY '<onlyoffice user password in .env>';
GRANT ALL PRIVILEGES ON onlyoffice_db.* TO '<onlyoffice user login in .env'@'%';
FLUSH PRIVILEGES;
