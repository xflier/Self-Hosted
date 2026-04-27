# RabbitMQ Service

This Docker Compose service runs RabbitMQ as the message broker for self-hosted applications.

## Service configuration

- **Service name**: `rabbitmq`
- **Container name**: `rabbitmq`
- **Image**: defined by `RABBITMQ_IMAGE` in the root `.env`
- **Restart policy**: `unless-stopped`
- **Network**: connected to the external `docker_net`
- **Ports**:
  - `15672:15672` for the RabbitMQ management UI
  - `5672:5672` is intentionally commented out and not exposed by default
- **Volumes**:
  - `${BASE_STORAGE_DIR}/rabbitmq` → `/var/lib/rabbitmq`

## Required environment variables

Define these values in the root `.env` file:

```env
RABBITMQ_IMAGE=your-rabbitmq-image
RABBITMQ_DEFAULT_USER=admin
RABBITMQ_DEFAULT_PASS=secret
RABBITMQ_DEFAULT_VHOST=/
BASE_STORAGE_DIR=/blk
```

Key variables:

- `RABBITMQ_IMAGE`: The Docker image used for RabbitMQ.
- `RABBITMQ_DEFAULT_USER`: Default RabbitMQ user.
- `RABBITMQ_DEFAULT_PASS`: Default RabbitMQ password.
- `RABBITMQ_DEFAULT_VHOST`: Default virtual host.
- `BASE_STORAGE_DIR`: Host base path for persistent data.

## Usage

From the repository root, start the service with:

```sh
docker compose -f RabbitMQ/docker-compose.yml up -d
```

Other services should connect to RabbitMQ over Docker networking using the hostname `rabbitmq` and port `5672`.

## Access

- Management UI: `http://<host>:15672`
- AMQP broker port: `5672` (internal Docker network only unless exposed)

## Notes

- The compose file preserves RabbitMQ data under `${BASE_STORAGE_DIR}/rabbitmq`.
- The host-level AMQP port `5672` is commented out by default for security. If you need external access, uncomment the port mapping in `docker-compose.yml`.
- Ensure `docker_net` exists before starting the service:

```sh
docker network create docker_net
```
