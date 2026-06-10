create user psono with password 'abc123abc123';
create database psono_db owner psono;
GRANT ALL PRIVILEGES ON DATABASE psono_db TO psono;
