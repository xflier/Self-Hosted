create user keycloak with password 'password_here';
create database keycloak_db owner keycloak;
GRANT ALL PRIVILEGES ON DATABASE keycloak_db TO keycloak;
