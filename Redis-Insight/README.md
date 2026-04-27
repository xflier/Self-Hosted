# Redis Insight Service

This service runs RedisInsight, a web-based management UI for Redis.

## Service configuration

- **Service name**: `redisinsight`
- **Container name**: `redisinsight`
- **Image**: `redis/redisinsight:latest`
- **Restart policy**: `always`
- **Network**: attached to the external `docker_net`
- **Port**:
  - `5540:5540`
- **Volume**:
  - `/blk/redis/insight:/data`
- **User**: `0:0`

## Environment variables

The compose file includes:

- `RI_APP_PORT=5540`

Optional variables you can uncomment or add:

- `RI_ENCRYPTION_KEY=a_very_long_random_string_here`
- `RI_STDOUT_LOGGER=true`

## Usage

From the repository root, start the service with:

```sh
docker compose -f Redis-Insight/docker-compose.yml up -d
```

Then access RedisInsight in your browser at:

```text
http://<host>:5540
```

## Notes

- The service stores data under `/blk/redis/insight` on the host.
- RedisInsight runs on port `5540` and connects to Redis instances from the UI.
- Ensure the `docker_net` network exists before starting:

```sh
docker network create docker_net
```

- If you need to persist configuration or session state, keep the `/blk/redis/insight` volume mounted.
