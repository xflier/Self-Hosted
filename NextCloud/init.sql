CREATE USER nextcloud WITH PASSWORD 'password_here';
CREATE DATABASE nextcloud_db OWNER nextcloud;
GRANT ALL PRIVILEGES ON DATABASE nextcloud_db TO nextcloud;