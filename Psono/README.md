# Psono Service

This folder contains a Psono password manager deployment.

## Configuration setup

1. Generate crypto keys with the `generateserverkeys` command provided by Psono.
2. Copy `settings.yaml.example` to `settings.yaml` and fill in the generated keys and your configuration.
3. Place both `config.json` and `settings.yaml` at `${BASE_STORAGE_DIR}/psono/`.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- PostgreSQL and Redis available on the Docker network

## Required variables

- `PSONO_IMAGE`
- `PSONO_SERVER_HOSTNAME`
- `SERVER_PROTOCOL`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `psono`
- Mounts:
  - `${BASE_STORAGE_DIR}/psono/config.json`
  - `${BASE_STORAGE_DIR}/psono/settings.yaml`
  - `${BASE_STORAGE_DIR}/psono/entrypoint.sh` — startup wrapper that merges CA bundles
  - `${BASE_STORAGE_DIR}/caddy/data/caddy/pki/authorities/local/root.crt` — Caddy internal root CA
- Depends on `postgres` and `redis`
- No host port published by default
- Entrypoint override via `command: sh /entrypoint.sh`
- `REQUESTS_CA_BUNDLE` set to `/combined-ca.crt` (merged system + Caddy CA bundle)

## SSL trust for OIDC (Keycloak)

Psono's Python backend calls Keycloak's OIDC endpoints over HTTPS via Caddy,
which uses a self-signed internal CA (`tls internal`). The `entrypoint.sh`
wrapper merges the container's system CA bundle with Caddy's root CA into
`/combined-ca.crt` at every startup, so the `requests` library trusts both
real SSL certificates and Caddy's internal certificates.

If Caddy's internal CA is ever regenerated, simply restart the Psono container
to pick up the new root certificate:

```sh
docker compose up -d psono
```

This CA bundle workaround is only needed when Caddy uses `tls internal`
(self-signed). **In production** with real domains and publicly trusted
certificates, the `entrypoint.sh` merge and the `REQUESTS_CA_BUNDLE`
environment variable can be removed.

## Start

```sh
docker compose up -d psono
```
