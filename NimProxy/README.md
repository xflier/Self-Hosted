# NimProxy

This folder contains NimProxy, a lightweight server application containerized with Docker Compose.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables

## Required variables

- `NIM_PROXY_IMAGE`
- `NIM_PROXY_SERVER_HOSTNAME`
- `UID`
- `GID`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `nim-proxy`
- Runs as `${UID}:${GID}`
- Listens on port `15800` internally
- No host port published by default; external access is expected through the Caddy reverse proxy at `${NIM_PROXY_SERVER_HOSTNAME}`
- `TRUST_PROXY=true` trusts the `X-Forwarded-*` headers from the reverse proxy
- Runs with a read-only root filesystem, all capabilities dropped, and `no-new-privileges` enabled
- Data persisted in `${BASE_STORAGE_DIR}/nim-proxy`

## Reverse proxy

NimProxy is fronted by Caddy in `Caddy/Caddyfile`:

```
${NIM_PROXY_SERVER_HOSTNAME} {
    tls internal
    reverse_proxy nim-proxy:15800
}
```

Caddy also receives `${NIM_PROXY_SERVER_HOSTNAME}` via the `Caddy/docker-compose.yml` environment so the block is served. **In production** with a real domain and CA-signed certificates, remove `tls internal` so Caddy obtains Let's Encrypt certificates automatically.

## Start

```sh
docker compose up -d nim-proxy
```
