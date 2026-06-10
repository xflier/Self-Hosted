# PostgreSQL Service

This folder contains a PostgreSQL database service for the stack.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables

## Required variables

- `POSTGRES_IMAGE`
- `POSTGRES_USER`
- `POSTGRES_PASSWORD`
- `POSTGRES_DB`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `postgres`
- Database persistence: `${BASE_STORAGE_DIR}/postgres`
- Uses `shm_size: 128mb`
- No host port is published by default
- Healthcheck uses `pg_isready`

## Setup scripts

Place initialization SQL scripts in `${BASE_STORAGE_DIR}/init/postgres` before first startup.

## Start

```sh
docker compose up -d postgres
```
