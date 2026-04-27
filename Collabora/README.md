# Collabora Service

This stack deploys Collabora Online alongside an OCIS collaboration service. It is designed to run with Docker Compose and expects an external `docker_net` network that connects Collabora, OCIS, and the reverse proxy.

## Overview

- `collabora`
  - Runs the Collabora Online server.
  - Serves WOPI traffic on internal port `9980`.
  - Is configured for external TLS termination through a reverse proxy.
  - Includes a healthcheck that validates Collabora discovery at `/hosting/discovery`.

- `collaboration`
  - Runs the OCIS collaboration service.
  - Connects to the OCIS service registry using `nats-js-kv`.
  - Uses `collaboration:9300` as the internal WOPI source.
  - Exposes gRPC on port `9301` and HTTP on port `9300`.

## Requirements

- External Docker network: `docker_net`
- A running OCIS deployment available to this compose stack
- A reverse proxy capable of routing traffic based on Caddy labels
- Valid environment variables in the root `.env` file

## Create the network

If the external network does not exist, create it with:

```sh
docker network create docker_net
```

## Required environment variables

The following variables are required in your root `.env` file or compose environment:

- `OCIS_IMAGE`
- `COLLABORA_IMAGE`
- `SERVER_PROTOCOL`
- `OCIS_SERVER_HOSTNAME`
- `COLLABORA_SERVER_HOSTNAME`
- `JWT_PRIVATE_KEY`
- `COLLABORA_ADMIN_USER`
- `COLLABORA_ADMIN_PASSWORD`

## Collabora proxy labels

The `collabora` service exposes these labels for automatic reverse proxy routing:

```yaml
labels:
  caddy: ${SERVER_PROTOCOL:?Variable is not set}://${COLLABORA_SERVER_HOSTNAME:?Variable is not set}
  caddy.reverse_proxy: "{{upstreams 9980}}"
```

This enables a Caddy proxy to route inbound requests to Collabora on port `9980`.

## Starting the stack

From the repository root, run:

```sh
docker compose -f Collabora/docker-compose.yml up -d
```

## Notes

- `collaboration` depends on `ocis` and `collabora`; ensure those services are available in your total deployment.
- `COLLABORATION_APP_ADDR` and `COLLABORATION_APP_ICON` are generated from `SERVER_PROTOCOL` and `COLLABORA_SERVER_HOSTNAME`.
- `COLLABORATION_APP_INSECURE` and `COLLABORATION_CS3API_DATAGATEWAY_INSECURE` are set to `true` because this stack uses insecure internal service communication behind the network boundary.
- TLS termination is handled by the proxy layer, not inside the Collabora container.
