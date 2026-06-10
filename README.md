# Self-Hosted Services

This repository contains a collection of self-hosted services orchestrated with Docker Compose. Each service lives in its own folder and can be started individually.

## Services

- `Adminer`
- `bin`
- `Caddy`
- `Caddy-Proxy`
- `Collabora`
- `Gitlab`
- `Hermes`
- `Keycloak`
- `MariaDB`
- `MemCached`
- `Ocis`
- `OnlyOffice`
- `Openclaw`
- `OpenWebUI`
- `PostgreSQL`
- `Psono`
- `RabbitMQ`
- `Redis`
- `Redis-Insight`
- `SeaDoc`
- `Seafile`
- `Vault-Warden`

## Getting started

1. Create the shared Docker network if it does not exist:
   ```sh
docker network create docker_net
```

2. Create or update the root `.env` file with required variables.

3. Start services from the repository root, for example:
   ```sh
docker compose up -d mariadb
```

4. Services that require a reverse proxy should be made available to the proxy and configured with the appropriate hostnames.

## Root environment variables

The repository root `.env` file should define storage, image, credential, and hostname values used by the service compose files.

Important values include:

- `BASE_STORAGE_DIR`
- `SERVER_PROTOCOL`
- `JWT_PRIVATE_KEY`
- Service image variables such as `MARIA_DB_IMAGE`, `POSTGRES_IMAGE`, `REDIS_IMAGE`, `PSONO_IMAGE`, `VAULT_WARDEN_IMAGE`, `OCIS_IMAGE`, `ONLYOFFICE_IMAGE`, `GITLAB_IMAGE`, `RABBITMQ_IMAGE`, `OPENCLAW_IMAGE`, `HERMES_AGENT_IMAGE`, `OPEN_WEBUI_IMAGE`
- Hostname variables such as `GITLAB_SERVER_HOSTNAME`, `OPEN_WEBUI_SERVER_HOSTNAME`, `KEYCLOAK_SERVER_HOSTNAME`, `SEAFILE_SERVER_HOSTNAME`, `ONLYOFFICE_SERVER_HOSTNAME`, `OCIS_SERVER_HOSTNAME`, `COLLABORA_SERVER_HOSTNAME`, `VAULT_WARDEN_SERVER_HOSTNAME`

## Notes

- Most services use the external Docker network `docker_net` for inter-service communication.
- Several services are expected to be reverse proxied rather than exposed directly on host ports.
- Check each folder's `README.md` for service-specific requirements and startup commands.
