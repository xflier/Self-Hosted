# OnlyOffice Document Server

This folder contains a self-hosted OnlyOffice Document Server deployment.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables
- PostgreSQL and RabbitMQ services available on the Docker network

## Required variables

- `ONLYOFFICE_IMAGE`
- `ONLYOFFICE_DB_USER`
- `ONLYOFFICE_DB_PASSWORD`
- `ONLYOFFICE_DB_NAME`
- `JWT_PRIVATE_KEY`
- `POSTGRES_DB`
- `RABBITMQ_DEFAULT_USER`
- `RABBITMQ_DEFAULT_PASS`
- `RABBITMQ_DEFAULT_VHOST`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `onlyoffice`
- Database connectivity is configured with `DB_HOST`, `DB_USER`, `DB_PWD`, and `DB_NAME`
- Uses RabbitMQ for `AMQP_URI`
- Persistence under `${BASE_STORAGE_DIR}/onlyoffice`
- `USE_UNAUTHORIZED_STORAGE=true`
- `WOPI_ENABLED=true` and `JWT_ENABLED=true`

## Usage

```sh
docker compose up -d onlyoffice
```

## Notes

- OnlyOffice is typically proxied through Caddy or a reverse proxy.
- Verify the database and RabbitMQ credentials before starting.
