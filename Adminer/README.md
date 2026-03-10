# Adminer

Adminer is a lightweight, web-based database management tool that supports multiple database systems including MySQL, MariaDB, PostgreSQL, SQLite, and more. It provides a simple interface for managing databases, tables, users, and data.

This service is primarily used for verifying database setups, such as initial schema creation, user permissions, and table structures during the configuration of other services in this repository.

## Prerequisites

- Docker Engine installed
- Access to the database services you want to manage (e.g., MariaDB, PostgreSQL running in the same network)
- Docker network docker_net created

## Usage

Adminer is not included in the main `.env` configuration and should be run independently when needed.

1. Navigate to the Adminer directory:
   ```sh
   cd Adminer
   ```

2. Start the service:
   ```sh
   docker compose up -d
   ```

3. Access Adminer in your browser at `http://localhost:18080` (or your configured domain/port).

4. Log in using your database credentials (host, username, password, database name).

## Stopping the Service

To stop Adminer:
```sh
docker compose down
```

## Notes

- Adminer runs on an external Docker network (`docker_net`) to communicate with other database containers.
- For security, consider restricting access or using it only during setup and development phases.
- The container exposes port 18080 on the host; adjust firewall rules as needed.

For more information, visit the [Adminer website](https://www.adminer.org/).

