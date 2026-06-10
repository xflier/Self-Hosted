# Redis Insight Service

This folder contains RedisInsight, a web-based GUI for inspecting Redis instances.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with `REDIS_INSIGHT_IMAGE` and `BASE_STORAGE_DIR`

## Service details

- Container name: `redisinsight`
- Published host port: `5540`
- Stores data in `${BASE_STORAGE_DIR}/redis/insight`
- Runs as `${UID}:${GID}`

## Start

```sh
docker compose up -d redisinsight
```

## Access

Open `http://<host>:5540` in your browser.
