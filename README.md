# Self-Hosted Services

This repository contains a collection of self-hosted services orchestrated with Docker Compose. Each service lives in its own folder and can be launched individually or together through the root Compose configuration.

## Root Compose configuration

The root `.env` file defines the Compose file list and base settings used across the stack.

### Compose files

The root `COMPOSE_FILE` includes:

- `MariaDB/docker-compose.yml`
- `PostgreSQL/docker-compose.yml`
- `RabbitMQ/docker-compose.yml`
- `Redis/docker-compose.yml`
- `Psono/docker-compose.yml`
- `Vault-Warden/docker-compose.yml`
- `Seafile/docker-compose.yml`
- `SeaDoc/docker-compose.yml`
- `OnlyOffice/docker-compose.yml`
- `Ocis/docker-compose.yml`
- `Collabora/docker-compose.yml`
- `Openclaw/docker-compose.yml`
- `Hermes/docker-compose.yml`
- `OpenWebUI/docker-compose.yml`
- `Caddy-Proxy/docker-compose.yml`

The compose path separator is defined by `COMPOSE_PATH_SEPARATOR=','`.

## Environment variables

The root `.env` file controls image versions, hostnames, storage paths, and credentials.

### Core variables

- `COMPOSE_FILE`: list of Compose files for the stack
- `COMPOSE_PATH_SEPARATOR`: separator used in `COMPOSE_FILE`
- `UID` / `GID`: host user/group IDs for volume ownership
- `BASE_STORAGE_DIR`: base path for persistent storage (default `/blk`)
- `SERVER_PROTOCOL`: protocol used by the reverse proxy (`https`)
- `JWT_PRIVATE_KEY`: shared JWT secret for internal services

### Image variables

- `SEAFILE_IMAGE`
- `CADDY_IMAGE`
- `SEADOC_IMAGE`
- `MARIA_DB_IMAGE`
- `MEMCACHED_IMAGE`
- `VAULT_WARDEN_IMAGE`
- `POSTGRES_IMAGE`
- `PSONO_IMAGE`
- `REDIS_IMAGE`
- `ONLYOFFICE_IMAGE`
- `GITLAB_IMAGE`
- `GITLAB_RUNNER_IMAGE`
- `RABBITMQ_IMAGE`
- `OCIS_IMAGE`
- `COLLABORA_IMAGE`
- `OPENCLAW_IMAGE`
- `HERMES_AGENT_IMAGE`
- `OPEN_WEBUI_IMAGE`

### Hostnames and startup parameters

- `VAULT_WARDEN_SERVER_HOSTNAME`
- `PSONO_SERVER_HOSTNAME`
- `ONLYOFFICE_SERVER_HOSTNAME`
- `SEAFILE_SERVER_HOSTNAME`
- `OCIS_SERVER_HOSTNAME`
- `GITLAB_SERVER_HOSTNAME`
- `COLLABORA_SERVER_HOSTNAME`
- `OPENCLAW_SERVER_HOSTNAME`
- `OPEN_WEBUI_SERVER_HOSTNAME`

### Authentication and service credentials

- `GITLAB_ROOT_EMAIL`
- `GITLAB_ROOT_PASSWD`
- `RABBITMQ_DEFAULT_USER`
- `RABBITMQ_DEFAULT_PASS`
- `RABBITMQ_DEFAULT_VHOST`
- `OCIS_ADMIN_PASSWORD`
- `COLLABORA_ADMIN_USER`
- `COLLABORA_ADMIN_PASSWORD`

### Database connectivity

- `MARIA_DB_HOST`
- `MARIA_DB_PORT`
- `MARIA_ROOT_PASSWORD`
- `SEAFILE_DB_USER`
- `SEAFILE_DB_PASSWORD`
- `SEAFILE_DB_NAME`
- `SEAFILE_CCNET_DB_NAME`
- `SEAFILE_SEAHUB_DB_NAME`
- `ONLYOFFICE_DB_USER`
- `ONLYOFFICE_DB_PASSWORD`
- `ONLYOFFICE_DB_NAME`
- `ONLYOFFICE_REDIS_DB`
- `POSTGRES_USER`
- `POSTGRES_PASSWORD`
- `POSTGRES_DB`
- `VAULT_DB_USER`
- `VAULT_DB_PASSWORD`
- `VAULT_DB`

### Cache provider

- `CACHE_PROVIDER`: `redis` or `memcached`
- `REDIS_HOST`
- `REDIS_PORT`
- `REDIS_PASSWORD`
- `MEMCACHED_HOST`
- `MEMCACHED_PORT`

### Initial setup variables

- `INIT_SEAFILE_ADMIN_EMAIL`
- `INIT_SEAFILE_ADMIN_PASSWORD`

### Optional configuration flags

- `ENABLE_SEADOC`
- `ENABLE_NOTIFICATION_SERVER`

## Startup

From the repository root, use Docker Compose with the root Compose file list:

```sh
docker compose up -d
```

If you need to control the Compose file list manually, use the `COMPOSE_FILE` value from `.env`.

## Network requirements

Many services use a shared external Docker network named `docker_net`. Create it if it does not exist:

```sh
docker network create docker_net
```

## Notes

- The `.env` file contains sensitive credentials. Keep it secure and do not commit it to public repositories.
- Service-specific README files exist inside each subfolder for detailed configuration and usage.
- The stack assumes TLS termination and proxy routing via the Caddy proxy service.
