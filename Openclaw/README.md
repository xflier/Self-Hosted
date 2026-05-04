# Openclaw Service

Openclaw provides a secure gateway and CLI container setup for the Openclaw application. This configuration runs a gateway service and a CLI service on the shared `docker_net` network, with persistent storage for runtime dependencies and user data.

## Services

- `openclaw-gateway`: Main gateway process for Openclaw.
- `openclaw-cli`: CLI helper container that shares network access with the gateway.

## Configuration

- **Image**: Set by `OPENCLAW_IMAGE` in the root `.env` file.
- **Container Names**: `openclaw-gateway` and `openclaw-cli`.
- **Network**: Uses the shared external network `docker_net`.
- **Restart Policy**: `unless-stopped` for the gateway service.

### Environment Variables

Define these variables in the repository root `.env` file:

```env
OPENCLAW_IMAGE=<openclaw_image>
OPENCLAW_GATEWAY_TOKEN=<gateway_token>
OPENCLAW_SERVER_HOSTNAME=<hostname>
TIME_ZONE=<timezone>
BASE_STORAGE_DIR=<data_root>
UID=<host_user_id>
GID=<host_group_id>
```

Optional variables used by the CLI service:

```env
OPENCLAW_IMAGE=openclaw:local
OPENCLAW_GATEWAY_TOKEN=<gateway_token>
# OPENCLAW_ALLOW_INSECURE_PRIVATE_WS=<value>
# CLAUDE_AI_SESSION_KEY=<value>
# CLAUDE_WEB_SESSION_KEY=<value>
# CLAUDE_WEB_COOKIE=<value>
```

## Volumes

The following host-mounted directories are required for persistent data:

- `${BASE_STORAGE_DIR}/openclaw/home` → `/root/.openclaw`
- `${BASE_STORAGE_DIR}/openclaw/runtime-deps` → `/var/lib/openclaw/plugin-runtime-deps`

## Ports and Proxy

The gateway is configured to expose its service through Caddy using the labels defined in `docker-compose.yml`.

- Caddy hostname: `OPENCLAW_SERVER_HOSTNAME`
- Gateway port: `18789`

The ports are commented out in compose and can be enabled if direct host access is needed.

## Healthcheck

The gateway service includes a healthcheck on `http://localhost:18789/healthz`.

## Usage

Start the service with:

```sh
docker compose -f Openclaw/docker-compose.yml up -d
```

Or start only the gateway and CLI services:

```sh
docker compose -f Openclaw/docker-compose.yml up -d openclaw-gateway openclaw-cli
```

## Notes

- `openclaw-cli` uses `network_mode: service:openclaw-gateway` so it shares the gateway's network namespace.
- `openclaw-cli` is configured with `no-new-privileges:true` and drops `NET_RAW` and `NET_ADMIN` capabilities.
- Make sure the external Docker network `docker_net` exists before starting the service.
