# Psono Service

This folder contains a Psono password manager deployment.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- PostgreSQL and Redis available on the Docker network

## Required variables

- `PSONO_IMAGE`
- `PSONO_SERVER_HOSTNAME`
- `SERVER_PROTOCOL`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `psono`
- Mounts:
  - `${BASE_STORAGE_DIR}/psono/config.json`
  - `${BASE_STORAGE_DIR}/psono/settings.yaml`
- Depends on `postgres` and `redis`
- No host port published by default

## Start

```sh
docker compose up -d psono
```
