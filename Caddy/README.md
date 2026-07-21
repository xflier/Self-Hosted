# Caddy Service

This folder contains the Caddy web server build and Docker Compose configuration used as a front-end reverse proxy for the self-hosted stack.

## Overview

- Builds a custom Caddy image using `xcaddy` and the `github.com/greenpau/caddy-security` plugin.
- Exposes HTTP and HTTPS on host ports `80` and `443`.
- Uses a shared Docker network `docker_net` for service discovery and proxying.

## Compose configuration

- Service name: `caddy`
- Container name: `caddy`
- Image: `self-hosted-caddy:latest`
- Restart policy: `unless-stopped`
- Adds `NET_ADMIN` capability
- Ports:
  - `80:80`
  - `443:443`
- Volumes:
  - `${BASE_STORAGE_DIR:?Variable is not set or empty}/caddy/data:/data`
  - `${BASE_STORAGE_DIR:?Variable is not set or empty}/caddy/etc:/etc/caddy`
  - `${BASE_STORAGE_DIR:?Variable is not set or empty}/caddy/site:/srv`
  - `${BASE_STORAGE_DIR:?Variable is not set or empty}/caddy/config:/config`
- Network: external `docker_net`

## Prerequisites

- Docker Engine and Docker Compose v2
- External Docker network created:
  ```sh
docker network create docker_net
```
- Root `.env` file that defines `BASE_STORAGE_DIR` and service hostname variables used for network aliases.

## Build and start

From the repository root:

```sh
docker compose -f Caddy/docker-compose.yml up -d
```

## Notes

- The `Dockerfile` builds a custom Caddy binary with the `caddy-security` plugin.
- Network aliases are configured for Keycloak, OpenWebUI, oCIS, OnlyOffice, Collabora, and Seafile hostnames.
- Place site content and Caddy configuration under the mounted `caddy` directories in the host storage path.

### TLS in local vs production

The [Caddyfile](Caddyfile) uses `tls internal` for all `.test.localhost` and `.self.test`
domains, which generates self-signed certificates. This is for local development only.

**In production** with real domains, remove the `tls internal` lines. Caddy will
automatically obtain and renew trusted Let's Encrypt certificates for any domain
it serves.
