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
- `BASE_STORAGE_DIR`
- `TIME_ZONE`
- `UID`
- `GID`

## Volumes

- `${BASE_STORAGE_DIR}/openclaw/home` → Openclaw state and configuration
- `${BASE_STORAGE_DIR}/openclaw/runtime-deps` → plugin runtime dependencies
- `${BASE_STORAGE_DIR}/openclaw/workspace` → shared Openclaw workspace
- `${BASE_STORAGE_DIR}/openclaw/config` → Openclaw config directory

## Notes

- The gateway is not published directly to the host by default.
- `openclaw-cli` uses `network_mode: service:openclaw-gateway` and shares the gateway network namespace.
- The gateway is intended to be reverse proxied through Caddy using the `caddy` labels.
- The gateway listens internally on port `18789`.

## Start

```sh
docker compose up -d openclaw-gateway openclaw-cli
```
