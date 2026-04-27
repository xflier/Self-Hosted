# Psono Service

This Docker Compose service runs Psono, a self-hosted password manager web application.

## Service configuration

- **Service name**: `psono`
- **Container name**: `psono`
- **Image**: defined by `PSONO_IMAGE` in the root `.env` file
- **Restart policy**: `unless-stopped`
- **Network**: connected to the external `docker_net`
- **Dependencies**: starts after `postgres`

## Volumes

The service mounts host files into the container for configuration:

- `${BASE_STORAGE_DIR}/psono/config.json` → `/usr/share/nginx/html/config.json`
- `${BASE_STORAGE_DIR}/psono/config.json` → `/usr/share/nginx/html/portal/config.json`
- `${BASE_STORAGE_DIR}/psono/settings.yaml` → `/root/.psono_server/settings.yaml`

This setup allows Psono to load UI and portal configuration from the shared host path.

## Reverse proxy labels

The service includes Caddy proxy labels for automatic routing:

```yaml
labels:
  caddy: ${SERVER_PROTOCOL:?Variable is not set}://${PSONO_SERVER_HOSTNAME:?Variable is not set}
  caddy.reverse_proxy: "{{upstreams 80}}"
```

This means a compatible Caddy proxy can route inbound traffic for `PSONO_SERVER_HOSTNAME` to the Psono container on port `80`.

## Required environment variables

Set the following values in the repository root `.env` file:

- `PSONO_IMAGE`
- `PSONO_SERVER_HOSTNAME`
- `SERVER_PROTOCOL`
- `BASE_STORAGE_DIR`

If the service configuration uses external environment management, ensure these variables are available to `docker compose`.

## Startup

From the repository root, run:

```sh
docker compose -f Psono/docker-compose.yml up -d
```

## Notes

- The container does not publish a host port by default. Access should be through the Docker network and reverse proxy.
- `postgres` is required and must be available on the shared `docker_net`.
- `net.core.somaxconn` is reduced to `16` in the container via `sysctls`.
- Uncomment or extend ports and environment settings in `docker-compose.yml` if you need direct host access or additional Psono options.
