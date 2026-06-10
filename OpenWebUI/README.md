# Open WebUI

Open WebUI provides a self-hosted web interface for AI and LLM model interaction.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- Keycloak available for OpenID Connect authentication

## Required variables

- `OPEN_WEBUI_IMAGE`
- `OPEN_WEBUI_SERVER_HOSTNAME`
- `PRIVATE_API_KEY`
- `OPEN_WEBUI_OAUTH_CLIENT_SECRET`
- `KEYCLOAK_SERVER_HOSTNAME`
- `SERVER_PROTOCOL`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `openwebui`
- Uses Keycloak OpenID Connect for authentication
- Data persisted in `${BASE_STORAGE_DIR}/openwebui`
- Uses local Caddy certificate trust bundle mounted from `${BASE_STORAGE_DIR}`

## Start

```sh
docker compose up -d openwebui
```
