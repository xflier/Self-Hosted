# Memcached Service

Memcached is a high-performance, distributed memory object caching system designed to speed up dynamic web applications by reducing database load. In this self-hosted stack, it serves as an optional caching backend for services like Seafile.

Memcached is one of two available caching options (the other being Redis). The choice is specified via the `CACHE_PROVIDER` environment variable in the dependent service's `docker-compose.yml` (e.g., set to `memcached` for Seafile).

## Configuration

- **Image**: Defined by `MEMCACHED_IMAGE` in the root `.env` file (default: `memcached:latest`).
- **Container Name**: `memcached`.
- **Memory Allocation**: Limited to 64MB via the entrypoint (`memcached -m 64`).
- **Network**: Attached to the shared `docker_net` network for secure inter-service communication.
- **Restart Policy**: `unless-stopped` to ensure automatic recovery from failures.

### Environment Variables

Set in the root `.env` file:

```env
MEMCACHED_IMAGE=memcached:latest
```

## Usage

1. Add `MemCached/docker-compose.yml` to your `COMPOSE_FILE` if using Memcached as the cache provider.
2. Configure the dependent service (e.g., in Seafile's compose file) with:
   ```yaml
   environment:
     - CACHE_PROVIDER=memcached
     - MEMCACHED_HOST=memcached
     - MEMCACHED_PORT=11211
   ```
3. Launch:
   ```sh
   docker compose up -d memcached
   ```
4. Services connect via hostname `memcached` on port 11211.

## Notes

- **Ephemeral Storage**: All data resides in memory; cache is cleared on restart.
- **Internal Access Only**: Not exposed to the host; accessible only within the Docker network.
- **Memory Tuning**: Adjust the `-m` parameter in the entrypoint for different memory limits.
- **Alternative**: If preferring Redis, use `Redis/docker-compose.yml` instead and set `CACHE_PROVIDER=redis`.

## Maintenance

- **Logs**: Monitor with `docker compose logs -f memcached`.
- **Performance**: Check memory usage; scale by increasing allocation or adding instances if needed.

For detailed documentation, visit the [official Memcached Docker image page](https://hub.docker.com/_/memcached).
