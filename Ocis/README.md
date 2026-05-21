# oCIS

Docker Compose setup for ownCloud Infinite Scale (oCIS) with OCIS and OnlyOffice collaboration integration.

This stack runs behind an external reverse proxy and uses the shared Docker network `docker_net`.

## Overview

The `docker-compose.yml` in this folder defines two services:

- `ocis`: the main oCIS platform.
- `collaboration-oo`: the OCIS collaboration service for OnlyOffice integration.

The stack expects TLS termination to happen at the proxy layer and uses Caddy labels for automatic routing.

## Prerequisites

- Docker Engine and Docker Compose v2.
- An external Docker network named `docker_net`:

```sh
docker network create docker_net
```

- A root `.env` file or exported environment variables for Docker Compose.

## Required environment variables

Set the following variables before starting the stack:

- `OCIS_IMAGE`
- `OCIS_ADMIN_PASSWORD`
- `SERVER_PROTOCOL`
- `OCIS_SERVER_HOSTNAME`
- `BASE_STORAGE_DIR`
- `JWT_PRIVATE_KEY`
- `ONLYOFFICE_SERVER_HOSTNAME`

Optional environment variables used in the compose file:

- `LOG_PRETTY`
- `COMPANION_SERVER_HOSTNAME`
- `COLLABORA_SERVER_HOSTNAME`

## Storage layout

Persistent data is stored under:

- `${BASE_STORAGE_DIR}/ocis/config`
- `${BASE_STORAGE_DIR}/ocis/data`

The compose file mounts `${BASE_STORAGE_DIR}/ocis/config/app-registry.yaml` to `/etc/ocis/app-registry.yaml` and the configuration directory to `/etc/ocis`.

## Proxy configuration

The `ocis` service is configured with Caddy labels:

```yaml
labels:
  caddy: ${SERVER_PROTOCOL:?Variable is not set}://${OCIS_SERVER_HOSTNAME:?Variable is not set}
  caddy.reverse_proxy: "{{upstreams 9200}}"
```

This allows a Caddy proxy to route external requests to oCIS on port `9200`.

## Access

- Web UI: `${SERVER_PROTOCOL}://${OCIS_SERVER_HOSTNAME}`

## Starting the stack

From the repository root:

```sh
docker compose -f Ocis/docker-compose.yml up -d
```

Or from the `Ocis/` directory:

```sh
docker compose up -d
```

## Service details

### `ocis`

- Runs the oCIS server.
- Uses `OCIS_INSECURE=true` and `PROXY_TLS=false` because external TLS is handled by the proxy.
- Exposes the web UI on internal port `9200`.
- Includes the OCIS gateway and registry services.

### `collaboration-oo`

- Runs the OCIS collaboration service for OnlyOffice.
- Connects to the OCIS registry at `ocis:9233`.
- Uses `COLLABORATION_WOPI_SRC=http://collaboration-oo:9300`.
- Sets `COLLABORATION_APP_ADDR` to the external OnlyOffice hostname.
- Uses `COLLABORATION_APP_INSECURE=true` and `COLLABORATION_CS3API_DATAGATEWAY_INSECURE=true` for internal network communication.

## Notes

- Ensure the `onlyoffice` service is reachable by the hostname specified in `ONLYOFFICE_SERVER_HOSTNAME` on the shared network.
- `OCIS_URL` is built from `SERVER_PROTOCOL` and `OCIS_SERVER_HOSTNAME`.
- The stack uses host gateway entries for `OCIS_SERVER_HOSTNAME`, `ONLYOFFICE_SERVER_HOSTNAME`, and `COMPANION_SERVER_HOSTNAME`.
- The reverse proxy should support dynamic container labels and route traffic to the internal service ports.

## Common commands

```sh
# Start oCIS
cd Ocis && docker compose up -d

# View oCIS logs
cd Ocis && docker compose logs -f ocis

# Stop oCIS
cd Ocis && docker compose down
```

## Troubleshooting

- Verify `docker_net` exists.
- Confirm `OCIS_SERVER_HOSTNAME` resolves to the correct host.
- Confirm `SERVER_PROTOCOL` is set correctly for your proxy (`https` for TLS).
- Check proxy labels and routing if the UI is not reachable.
