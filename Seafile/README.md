# Seafile Service

This folder contains a Seafile file syncing and sharing deployment.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- MariaDB and Redis available on the Docker network

## Required variables

- `SEAFILE_IMAGE`
- `SEAFILE_SERVER_HOSTNAME`
- `SERVER_PROTOCOL`
- `MARIA_DB_HOST`
- `MARIA_DB_PORT`
- `SEAFILE_DB_USER`
- `SEAFILE_DB_PASSWORD`
- `INIT_SEAFILE_ADMIN_EMAIL`
- `INIT_SEAFILE_ADMIN_PASSWORD`
- `JWT_PRIVATE_KEY`
- `CACHE_PROVIDER`
- `REDIS_HOST`
- `REDIS_PORT`
- `REDIS_PASSWORD`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `seafile`
- Stores all data in `${BASE_STORAGE_DIR}/seafile`
- Uses the Seafile image defined in `.env`
- Depends on `mariadb` and `redis`
- `ENABLE_SEADOC=false` by default
- `ENABLE_GO_FILESERVER=false` by default
- Caddy labels are commented out by default

## Start

```sh
docker compose up -d seafile
```

## Notes

- Configure Seafile integration options in `seahub_settings.py` for OnlyOffice or SeaDoc.
