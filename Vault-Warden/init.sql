CREATE DATABASE vaultwarden CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'vault'@'%' IDENTIFIED BY 'password_here';
GRANT ALL ON `vaultwarden`.* TO 'vault'@'%';
FLUSH PRIVILEGES;
