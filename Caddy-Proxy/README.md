# Caddy Proxy Service

This service runs the `caddy-docker-proxy` image to automatically discover Docker containers with Caddy labels and proxy traffic for them.

## Prerequisites

- Docker Engine installed
- External Docker network `docker_net`
- Root `.env` file with `BASE_STORAGE_DIR` (if different from `/blk`)

## Configuration

- Image: `${CADDY_PROXY_IMAGE:-lucaslorentz/caddy-docker-proxy:alpine}`
- Container name: `caddy-proxy`
- Ports: `80:80`, `443:443/tcp`, `443:443/udp`
- Volumes:
  - `/var/run/docker.sock:/var/run/docker.sock`
  - `${BASE_STORAGE_DIR:-/blk}/caddy-proxy:/data/caddy`
- Network: `docker_net`

## Start

From the repository root:

```sh
docker compose -f Caddy-Proxy/docker-compose.yml up -d
```

## Notes

- Services must define Caddy labels for automatic routing.
- The proxy uses Docker labels to create routes and manage TLS certificates.
