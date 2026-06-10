# Adminer

Adminer is a lightweight, web-based database administration tool. It provides a simple UI for inspecting and managing databases such as MariaDB, PostgreSQL, SQLite, and more.

## Prerequisites

- Docker Engine installed
- External Docker network `docker_net` created:
  ```sh
docker network create docker_net
  ```

## Usage

From the repository root:

```sh
docker compose up -d adminer
```

Access Adminer at `http://localhost:18080`.

## Service details

- Container name: `adminer`
- Image: `adminer:latest`
- Host port `18080` maps to container port `8080`
- Network: `docker_net`

## Stop

```sh
docker compose down
```
