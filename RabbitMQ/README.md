# RabbitMQ Service

This folder contains a RabbitMQ message broker deployment.

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` with required variables

## Required variables

- `RABBITMQ_IMAGE`
- `RABBITMQ_DEFAULT_USER`
- `RABBITMQ_DEFAULT_PASS`
- `RABBITMQ_DEFAULT_VHOST`
- `BASE_STORAGE_DIR`

## Service details

- Container name: `rabbitmq`
- Published host port: `15672` for the management UI
- AMQP port `5672` is not exposed by default
- Data persisted in `${BASE_STORAGE_DIR}/rabbitmq`

## Start

```sh
docker compose up -d rabbitmq
```
