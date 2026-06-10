# Redis Service

This folder contains a Redis deployment for caching and session storage.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with `REDIS_IMAGE` and `REDIS_PASSWORD`

## Service details

- Container name: `redis`
- Uses `redis-server --requirepass "$REDIS_PASSWORD"`
- No host ports exposed by default
- Connect from other containers using hostname `redis` and port `6379`

## Start

```sh
docker compose up -d redis
```
