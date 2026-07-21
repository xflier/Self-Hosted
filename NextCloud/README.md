# NextCloud Service

This folder contains a NextCloud deployment for file sync and sharing.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- PostgreSQL and Redis available on the Docker network

## Required variables

- `NEXTCLOUD_IMAGE`
- `NEXTCLOUD_SERVER_HOSTNAME`
- `NEXTCLOUD_DB_USER`
- `NEXTCLOUD_DB_PASSWORD`
- `NEXTCLOUD_DB`
- `NEXTCLOUD_ADMIN_USER`
- `NEXTCLOUD_ADMIN_PASSWORD`
- `REDIS_HOST`
- `REDIS_PASSWORD`
- `SERVER_PROTOCOL`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `nextcloud`
- Connects to PostgreSQL and Redis
- Data persisted in `${BASE_STORAGE_DIR}/nextcloud`
- No host port published by default
- Caddy labels are defined for reverse proxy access

## Start

```sh
docker compose up -d nextcloud
```

## Notes

- First-time setup creates the admin user defined in `.env`.
- Access the web UI via the configured `NEXTCLOUD_SERVER_HOSTNAME`.