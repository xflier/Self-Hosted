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

- `collabora` service uses `DONT_GEN_SSL_CERT=YES` and `--o:ssl.enable=false`
  to delegate TLS to the reverse proxy. The `--o:ssl.termination=true` tells
  Collabora that TLS is handled upstream. This is suitable for local setups where
  the reverse proxy uses `tls internal`.
  **In production** with real CA-signed certificates you can keep this setup if
  TLS still terminates at the proxy, or remove these flags and let Collabora
  handle its own TLS.
- `COLLABORATION_APP_INSECURE=true` and `COLLABORATION_CS3API_DATAGATEWAY_INSECURE=true`
  are set for the internal OCIS collaboration service. These should be removed in
  production if real TLS certificates are used between services.
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
