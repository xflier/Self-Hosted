# Keycloak for oCIS

This folder contains a Keycloak deployment for OpenID Connect authentication.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- PostgreSQL available as `postgres` on the Docker network
- Root `.env` with required variables

## Required variables

- `KEYCLOAK_IMAGE`
- `KEYCLOAK_SERVER_HOSTNAME`
- `KEYCLOAK_ADMIN_USER`
- `KEYCLOAK_ADMIN_PASSWORD`
- `KEYCLOAK_DB`
- `KEYCLOAK_DB_USER`
- `KEYCLOAK_DB_PASSWORD`
- `BASE_STORAGE_DIR`

## Service details

- Uses the Keycloak Docker image and starts with `start --spi-connections-http-client-default-disable-trust-manager=true --import-realm`
- Connects to PostgreSQL via `KC_DB_URL`
- Uses `KC_PROXY_HEADERS=xforwarded`
- Exposes no host HTTP port by default; access is expected through a reverse proxy

## Start

```sh
docker compose up -d keycloak
```

## Import realm

Use the `realm/ocis-realm.json` definition to configure oCIS integration.
