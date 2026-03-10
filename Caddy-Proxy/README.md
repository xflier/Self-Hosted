# Caddy Proxy Service

Caddy is a modern web server and reverse proxy that automatically handles HTTPS certificates via Let's Encrypt. In this setup, it acts as the entry point for all self-hosted services, routing traffic based on domain names and providing SSL termination.

This service uses the [Caddy Docker Proxy](https://github.com/lucaslorentz/caddy-docker-proxy) plugin, which reads Docker container labels to dynamically configure routing without manual Caddyfile editing.

## Configuration

- **Image**: Defined by `SEAFILE_CADDY_IMAGE` in the root `.env` file (typically `lucaslorentz/caddy-docker-proxy:alpine`).
- **Container Name**: `caddy-proxy`.
- **Ports**: Exposes 80 (HTTP) and 443 (HTTPS/TCP+UDP) on the host.
- **Network**: Connected to `docker_net` for service discovery.
- **Volumes**:
  - `/var/run/docker.sock`: Allows Caddy to inspect running containers and their labels.
  - `${BASE_STORAGE_DIR:-/blk}/caddy-proxy:/data/caddy`: Persists certificates, keys, and configuration data.

### Environment Variables

Set in the root `.env` file:

```env
SEAFILE_CADDY_IMAGE=lucaslorentz/caddy-docker-proxy:alpine
BASE_STORAGE_DIR=/blk  # Host path for persistent data
```

## How It Works

Caddy automatically discovers services by reading Docker labels on containers. For example, a service might have:

```yaml
labels:
  caddy: example.com
  caddy.reverse_proxy: "{{upstreams 80}}"
```

This tells Caddy to route `https://example.com` to the container's port 80, obtaining and renewing TLS certificates automatically.

## Usage

1. Include `Caddy-Proxy/docker-compose.yml` in your `COMPOSE_FILE`.
2. Ensure other services have appropriate Caddy labels in their compose files.
3. Start Caddy:
   ```sh
   docker compose up -d caddy
   ```
4. Caddy will listen on ports 80/443 and proxy requests based on container labels.

## Requirements

- The `docker_net` network must exist (create with `docker network create docker_net`).
- Services must be on the same network and have Caddy labels configured.
- DNS records for domains should point to the host running Caddy.

For more details, refer to the [Caddy Docker Proxy documentation](https://github.com/lucaslorentz/caddy-docker-proxy).
