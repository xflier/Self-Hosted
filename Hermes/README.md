# Hermes Agent

Hermes is an AI agent platform that provides multi-agent capabilities for autonomous task execution and reasoning. It includes a dashboard for monitoring and managing multiple agent instances.

## Configuration

- **Agent image**: `HERMES_AGENT_IMAGE` in the root `.env`
- **Workspace image**: `HERMES_WORKSPACE_IMAGE` in the root `.env`
- **Network**: attached to the shared `docker_net` network
- **Restart policy**: `unless-stopped`
- **Resource limits**: 4GB memory, 2 CPUs for each agent container

## Services

This compose file defines three containers:

1. **hermes-agent**
   - Main gateway agent
   - Runs `gateway run`
   - Dashboard enabled with `HERMES_DASHBOARD=1`
   - API server enabled with `API_SERVER_ENABLED=true`
   - Data stored at `${BASE_STORAGE_DIR}/hermes/agent1`

2. **instance-agent**
   - Secondary Hermes agent instance
   - Shares the same base image and config style as `hermes-agent`
   - Runs with its own UID and data volume
   - Data stored at `${BASE_STORAGE_DIR}/hermes/instance`

3. **hermes-workspace**
   - Hermes workspace frontend
   - Connects to `instance-agent` over its internal API and dashboard endpoints
   - Uses `HERMES_WORKSPACE_PASSWORD` for login
   - Exposes the workspace via Caddy reverse proxy using `HERMES_WORKSPACE_SERVER_HOSTNAME`

## Required Environment Variables

Define the following in the root `.env` file:

```env
HERMES_AGENT_IMAGE=nousresearch/hermes-agent:latest
HERMES_WORKSPACE_IMAGE=ghcr.io/outsourc-e/hermes-workspace:latest
BASE_STORAGE_DIR=/blk
PRIVATE_API_KEY=<your-api-key>
HERMES_WORKSPACE_PASSWORD=<workspace-password>
HERMES_WORKSPACE_SERVER_HOSTNAME=<workspace-hostname>
SERVER_PROTOCOL=https
```

## Persistent Storage

Host volumes mount:
- `${BASE_STORAGE_DIR}/hermes/agent1:/opt/data` for `hermes-agent`
- `${BASE_STORAGE_DIR}/hermes/instance:/opt/data` for `instance-agent`
- `${BASE_STORAGE_DIR}/hermes/instance:/home/workspace/.hermes` for `hermes-workspace`
- `${BASE_STORAGE_DIR}/hermes/workspace:/workspace` for `hermes-workspace`

## Starting Hermes

1. Add `Hermes/docker-compose.yml` to your `COMPOSE_FILE`.
2. Start the Hermes stack:

```sh
docker compose up -d hermes-agent instance-agent hermes-workspace
```

3. Access the workspace frontend using the configured hostname:

```text
https://${HERMES_WORKSPACE_SERVER_HOSTNAME}
```

> The agent API and dashboard ports are not exposed by default in `docker-compose.yml`; the workspace service is intended to provide the main external interface.

## Features

- Multi-agent orchestration
- Real-time dashboard monitoring
- API-driven agent interaction
- Autonomous task execution
- Configurable resource limits
