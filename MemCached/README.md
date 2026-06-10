# Memcached Service

This folder contains a Memcached service for in-memory caching.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with `MEMCACHED_IMAGE`

## Configuration

- Container name: `memcached`
- Network: `docker_net`
- No ports published by default
- Default memory limit is configured in the container command

## Usage

```sh
docker compose up -d memcached
```

## Notes

- Use Redis instead if you need persistent caching.
- Services connect to `memcached` on port `11211` internally.
