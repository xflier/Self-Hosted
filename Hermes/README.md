# Hermes Agent

This folder contains a Docker Compose deployment for Hermes agent instances and the Hermes workspace frontend.

## Services

- `hermes-agent`
- `instance-agent`
- `hermes-workspace`

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables

## Required variables

- `HERMES_AGENT_IMAGE`
- `HERMES_WORKSPACE_IMAGE`
- `PRIVATE_API_KEY`
- `HERMES_WORKSPACE_PASSWORD`
- `HERMES_WORKSPACE_SERVER_HOSTNAME`
- `SERVER_PROTOCOL`
- `BASE_STORAGE_DIR`

## Behavior

- Both `hermes-agent` and `instance-agent` run the Hermes gateway.
- `hermes-workspace` connects to `instance-agent` and provides the web UI.
- No host ports are published by default; external access is expected through the reverse proxy.
- `hermes-workspace` exposes its hostname via Caddy labels.
- `HERMES_DASHBOARD_INSECURE=1` is set to allow HTTP connections behind the
  reverse proxy. **In production** with proper TLS termination, this can be
  removed if all traffic uses HTTPS.

## Start

```sh
docker compose up -d hermes-agent instance-agent hermes-workspace
```
