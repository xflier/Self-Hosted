# MariaDB Service

This folder contains a MariaDB database service for the stack.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with `MARIA_DB_IMAGE` and `MARIADB_ROOT_PASSWORD`

## Configuration

- Image: `${MARIA_DB_IMAGE:-mariadb:latest}`
- Container name: `mariadb`
- Persistence: `${BASE_STORAGE_DIR:-/blk}/mariadb/db`
- Network: `docker_net`
- Environment variable: `MARIADB_ROOT_PASSWORD`

## Usage

```sh
docker compose up -d mariadb
```

## Notes

- The service is intended for internal Docker network use only.
- The compose file does not expose MySQL port to the host by default.
