# Collabora Service

This folder contains a Docker Compose setup for Collabora Online and a related OCIS collaboration service.

## Services

- `collabora`: runs the Collabora Online document editor.
- `collaboration`: runs the OCIS collaboration service.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required service variables
- OCIS deployment available on the shared network

## Configuration

Required `.env` variables:

- `OCIS_IMAGE`
- `COLLABORA_IMAGE`
- `SERVER_PROTOCOL`
- `OCIS_SERVER_HOSTNAME`
- `COLLABORA_SERVER_HOSTNAME`
- `JWT_PRIVATE_KEY`
- `COLLABORA_ADMIN_USER`
- `COLLABORA_ADMIN_PASSWORD`

The compose file sets:

- `COLLABORATION_APP_ADDR` and `COLLABORATION_APP_ICON` from the Collabora hostname
- `COLLABORATION_WOPI_SRC=http://collaboration:9300`
- `COLLABORATION_APP_INSECURE=true`
- `COLLABORATION_CS3API_DATAGATEWAY_INSECURE=true`

## Notes

- `collabora` service uses `DONT_GEN_SSL_CERT=YES` and `--o:ssl.enable=false` to delegate TLS to the reverse proxy.
- The compose file does not publish Collabora ports directly to the host.
- Caddy labels in the compose file are commented out by default.

## Start

```sh
docker compose up -d collabora collaboration
```

Or from the repository root:

```sh
docker compose -f Collabora/docker-compose.yml up -d
```
