# Vault-Warden Service

This folder contains Vault-Warden, a lightweight Bitwarden-compatible password manager.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- MariaDB available on the Docker network

## Required variables

- `VAULT_WARDEN_IMAGE`
- `VAULT_DB_USER`
- `VAULT_DB_PASSWORD`
- `VAULT_DB`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `vaultwarden`
- Runs as `${UID}:${GID}`
- Stores data in `${BASE_STORAGE_DIR}/vault_warden`
- Connects to MariaDB via `DATABASE_URL`
- `SIGNUPS_ALLOWED=true` by default
- No host port published by default
- Mounts Caddy's internal root CA (`SSL_CERT_FILE`, `REQUESTS_CA_BUNDLE`) so the
  Bitwarden API calls trust the reverse proxy's self-signed certificate.
  **In production** with real CA-signed certificates, these environment variables
  can be removed.

## Start

```sh
docker compose up -d vaultwarden
```
