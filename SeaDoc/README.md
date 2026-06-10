# SeaDoc Service

This folder contains SeaDoc, a collaborative document editor that can integrate with Seafile.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- Seafile and MariaDB available on the Docker network

## Required variables

- `SEADOC_IMAGE`
- `MARIA_DB_HOST`
- `MARIA_DB_PORT`
- `SEAFILE_DB_USER`
- `SEAFILE_DB_PASSWORD`
- `SEAFILE_SEAHUB_DB_NAME`
- `TIME_ZONE`
- `JWT_PRIVATE_KEY`
- `SEAFILE_SERVER_HOSTNAME`
- `SERVER_PROTOCOL`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `seadoc`
- Stores data in `${BASE_STORAGE_DIR}/seadoc`
- Connects to MariaDB and Seafile
- Does not publish ports by default
- Caddy labels are commented out by default

## Start

```sh
docker compose up -d seadoc
```
