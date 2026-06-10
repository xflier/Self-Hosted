# oCIS

This folder contains the oCIS platform deployment and its collaboration integration.

## Services

- `ocis`: oCIS platform
- `collaboration-oo`: OCIS collaboration integration for OnlyOffice
- initialization containers for web extensions: `unzip-init`, `photo-addon-init`, `progressbars-init`, `jsonviewer-init`, `externalsites-init`, `drawio-init`

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- PostgreSQL and Keycloak available on the Docker network

## Required variables

- `OCIS_IMAGE`
- `SERVER_PROTOCOL`
- `OCIS_SERVER_HOSTNAME`
- `KEYCLOAK_SERVER_HOSTNAME`
- `JWT_PRIVATE_KEY`
- `ONLYOFFICE_SERVER_HOSTNAME`
- `BASE_STORAGE_DIR`

## Notes

- `ocis` runs with `OCIS_INSECURE=true` and `PROXY_TLS=false` because TLS is handled by the reverse proxy.
- `collaboration-oo` uses OnlyOffice values and internal OCIS URLs.
- The init containers populate web extensions into `${BASE_STORAGE_DIR}/ocis/data/apps`.

## Start

```sh
docker compose up -d ocis collaboration-oo
```
