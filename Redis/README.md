# Redis Service

Redis is an open-source, in-memory data structure store used as a database, cache, and message broker. In this setup, it provides caching and session storage for services like Seafile and can optionally cache for Psono.

## Configuration

- **Image**: Specified by `REDIS_IMAGE` in the root `.env` file (default: `redis:latest`).
- **Container Name**: `redis`.
- **Network**: Attached to the shared `docker_net` network.
- **Restart Policy**: `unless-stopped` for automatic recovery.
- **Authentication**: Password-protected with `REDIS_PASSWORD`.

### Environment Variables

Define in the root `.env` file:

```env
REDIS_IMAGE=redis
REDIS_PASSWORD=<strong_password>
```

## Usage

1. Include `Redis/docker-compose.yml` in your `COMPOSE_FILE` if a service requires caching (e.g., Seafile).
2. Start the service:
   ```sh
   docker compose up -d redis
   ```
3. Other containers can connect using hostname `redis`, port 6379, with the password.

## Integration Examples

### With Seafile

In Seafile's environment variables, set:

```env
CACHE_PROVIDER=redis
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=<same_password>
```

For detailed documentation, visit the [official Redis website](https://redis.io/) and [Docker Hub page](https://hub.docker.com/_/redis).
