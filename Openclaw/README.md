# Openclaw Service

This directory contains the Openclaw Docker Compose setup for the gateway and CLI containers.
The stack is designed to run on the external `docker_net` network and expects a root `.env` file to define image, storage, and runtime variables.

## Services

- **openclaw-gateway**: The main Openclaw gateway service, responsible for device authentication, routing, and the control UI.
- **openclaw-cli**: A CLI helper container that runs in the same network namespace as the gateway for administrative commands.

## Docker Compose Highlights

- `image`: set via `OPENCLAW_IMAGE`
- `container_name`: `openclaw-gateway` and `openclaw-cli`
- `user`: runs as `${UID}:${GID}`
- `network`: uses external `docker_net`
- `restart`: `unless-stopped` for `openclaw-gateway`
- `network_mode`: `service:openclaw-gateway` for `openclaw-cli`
- no published ports by default; the gateway is expected to be reverse proxied through Caddy

## Environment Variables

Put these in the repository root `.env` file before starting the services:

```env
OPENCLAW_IMAGE=ghcr.io/openclaw/openclaw:slim
OPENCLAW_GATEWAY_TOKEN=<secure-token>
OPENCLAW_SERVER_HOSTNAME=openclaw.test.localhost
OPENCLAW_GATEWAY_BIND=lan
OPENCLAW_GATEWAY_PORT=18789
OPENCLAW_BRIDGE_PORT=18790
BASE_STORAGE_DIR=/blk
TIME_ZONE=America/New_York
UID=0
GID=0
```

## openclaw-gateway

The gateway container starts with:

```yaml
command:
  [
    "node",
    "dist/index.js",
    "gateway",
    "--bind",
    "${OPENCLAW_GATEWAY_BIND:-lan}",
    "--port",
    "18789"
  ]
```

### Notes

- The container listens on port `18789` internally.
- The Compose file does not expose the port on the host by default.
- Caddy reverse proxy labels are used to route traffic to the service.

## openclaw-cli

The CLI container is configured as:

- `network_mode: service:openclaw-gateway`
- `entrypoint: ["node", "dist/index.js"]`
- `stdin_open: true`
- `tty: true`

It also sets `OPENCLAW_ALLOW_INSECURE_PRIVATE_WS=true` and `BROWSER=echo` so that CLI commands can run without attempting to launch a browser.

## Volumes

Host data is persisted under `${BASE_STORAGE_DIR}`:

- `${BASE_STORAGE_DIR}/openclaw/home:/root/.openclaw`
- `${BASE_STORAGE_DIR}/openclaw/runtime-deps:/var/lib/openclaw/plugin-runtime-deps`
- `${BASE_STORAGE_DIR}/openclaw/workspace:/root/.openclaw/workspace`
- `${BASE_STORAGE_DIR}/openclaw/config:/home/node/.config/openclaw` for the gateway
- `${BASE_STORAGE_DIR}/openclaw/config:/root/.config/openclaw` for the CLI

## Reverse Proxy (Caddy)

The gateway includes Caddy labels for reverse proxying:

```yaml
labels:
  caddy: ${OPENCLAW_SERVER_HOSTNAME:?Variable is not set}
  caddy.reverse_proxy: "{{upstreams 18789}}"
  caddy.reverse_proxy.0_header_up: "Host {host}"
  caddy.reverse_proxy.1_header_up: "X-Real-IP {remote_host}"
```

- `OPENCLAW_SERVER_HOSTNAME` should resolve to the public hostname used by the control UI.
- Caddy forwards the original `Host` and `X-Real-IP` headers.

## Healthcheck

The gateway healthcheck calls:

```sh
CMD node -e "fetch('http://localhost:18789/healthz').then((r)=>process.exit(r.ok?0:1)).catch(()=>process.exit(1))"
```

- interval: `30s`
- timeout: `5s`
- retries: `5`
- start_period: `20s`

## Startup

Start the services with:

```sh
docker compose -f Openclaw/docker-compose.yml up -d openclaw-gateway openclaw-cli
```

If you need to run one-off commands inside the gateway container:

```sh
docker compose -f Openclaw/docker-compose.yml run --rm --no-deps --entrypoint node openclaw-gateway dist/index.js <command>
```

## Configuration and Onboarding

Example onboarding command:

```sh
docker compose -f Openclaw/docker-compose.yml run --rm --no-deps --entrypoint node openclaw-gateway \
  dist/index.js onboard --mode local --no-install-daemon
```

Example config update for trusted proxies and allowed origins:

```sh
docker compose -f Openclaw/docker-compose.yml run --rm --no-deps --entrypoint node openclaw-gateway \
  dist/index.js config set --batch-json '[{"path":"gateway.trustedProxies","value":["172.18.0.0/16","127.0.0.1"]},{"path":"gateway.controlUi.allowedOrigins","value":["https://openclaw.test.localhost"]}]'
```

## Access

Once the service is running and Caddy is configured, access the control UI at:

```sh
https://${OPENCLAW_SERVER_HOSTNAME}
```

## Notes

- Make sure the external Docker network `docker_net` exists before starting the stack.
- The gateway token is required for devices to register.
- The CLI container uses the same Openclaw image and shares the gateway network namespace.
- The compose file currently does not publish gateway ports to the host; proxying is expected.
