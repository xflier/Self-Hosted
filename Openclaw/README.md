# Openclaw Service

This folder contains an Openclaw gateway deployment and a CLI helper container.

## Services

- `openclaw-gateway`
- `openclaw-cli`

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables

## Required variables

- `OPENCLAW_IMAGE`
- `OPENCLAW_GATEWAY_TOKEN`
- `OPENCLAW_SERVER_HOSTNAME`
- `OPENCLAW_GATEWAY_BIND`
- `OPENCLAW_GATEWAY_PORT`
- `OPENCLAW_BRIDGE_PORT`
- `BASE_STORAGE_DIR`
- `TIME_ZONE`
- `UID`
- `GID`

## Notes

- The gateway is not published directly to the host by default.
- `openclaw-cli` runs in the gateway network namespace.
- The gateway is expected to be reverse proxied using Caddy labels.

## Start

```sh
docker compose up -d openclaw-gateway openclaw-cli
```
