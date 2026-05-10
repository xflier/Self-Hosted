# Hermes Agent

Hermes is an AI agent platform that provides multi-agent capabilities for autonomous task execution and reasoning. It includes a dashboard for monitoring and managing multiple agent instances.

## Configuration

- **Image**: Specified by `HERMES_AGENT_IMAGE` in the root `.env` file.
- **Network**: Attached to the shared `docker_net` network.
- **Restart Policy**: `unless-stopped` for automatic recovery.
- **Resource Limits**: 4GB memory, 2 CPUs per agent.

### Agents

This service runs multiple Hermes agent instances:

1. **hermes-agent** (main gateway agent)
   - Runs with `gateway run` command
   - Exposes dashboard on port 9119
   - Provides API server functionality

2. **xflier-agent** (secondary agent)
   - Mirrors main agent configuration
   - Exposes dashboard on port 19119
   - Separate data volume

### Environment Variables

Define these in the root `.env` file:

```env
HERMES_AGENT_IMAGE=<image>
HERMES_SERVER_HOSTNAME=hermes.example.com
HERMES_DASHBOARD=1
API_SERVER_ENABLED=true
API_SERVER_HOST=0.0.0.0
PRIVATE_API_KEY=<your-api-key>
BASE_STORAGE_DIR=/blk
```

### Persistent Storage

Data is stored on the host at:
- `${BASE_STORAGE_DIR}/hermes/agent1` → `/opt/data` (hermes-agent)
- `${BASE_STORAGE_DIR}/hermes/xflier` → `/opt/data` (xflier-agent)

Each agent maintains its own data, models, and configuration state.

## Usage

1. Include `Hermes/docker-compose.yml` in your `COMPOSE_FILE`.
2. Start the service:
   ```sh
   docker compose up -d hermes-agent xflier-agent
   ```
3. Access the dashboards at:
   - Main agent: `http://localhost:9119`
   - Secondary agent: `http://localhost:19119`
4. Interact with agents via the API using the configured `PRIVATE_API_KEY`.

## Features

- Multi-agent orchestration
- Real-time dashboard monitoring
- API-driven agent interaction
- Autonomous task execution
- Configurable resource limits
