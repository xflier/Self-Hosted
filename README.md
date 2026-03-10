# Self-Hosted Services

This repository documents Docker Compose configurations for self-hosting a suite of personal and productivity services. Each service runs in its own container and is designed for individual or small-team use, with automatic HTTPS handling via Caddy Proxy.

## Overview of Services

| Service | Description | Dependencies |
|---------|-------------|--------------|
| **Seafile** | File sharing and synchronization platform | MariaDB, Redis |
| **OnlyOffice** | Collaborative document editing suite | None |
| **Psono** | Secure password manager | PostgreSQL |
| **Vault-Warden** | Bitwarden-compatible password manager | None (optional DB) |
| **Caddy-Proxy** | Reverse proxy with automatic HTTPS | None |
| **MariaDB** | MySQL-compatible database | None |
| **PostgreSQL** | Advanced relational database | None |
| **Redis** | In-memory data structure store | None |
| **Memcached** | Distributed memory object caching | None |
| **Adminer** | Web-based database management tool | None (accesses other DBs) |
| **SeaDoc** | Document collaboration (integrates with Seafile) | Seafile |

## Architecture

- Each service resides in its own subdirectory with a dedicated `docker-compose.yml`.
- Dependencies are managed via `depends_on` in compose files (e.g., Seafile requires a database).
- Optional integrations: Seafile can integrate with OnlyOffice and/or SeaDoc.
- All services connect via a shared Docker network (`docker_net`).

## Getting Started

### Prerequisites

1. **Docker Engine** and **Docker Compose v2** installed on your host system.
2. **DNS Records**: Configure subdomains for each service (e.g., `seafile.example.com`, `psono.example.com`) pointing to your server's IP.
3. **Docker Network**: Create the shared network:
   ```sh
   docker network create docker_net
   ```

### Configuration

1. Copy or create a `.env` file in the repository root to define environment variables.
2. Set `COMPOSE_FILE` to a comma-separated list of compose files for the services you want to enable. For example:
   ```
   COMPOSE_FILE=Caddy-Proxy/docker-compose.yml,MariaDB/docker-compose.yml,Seafile/docker-compose.yml
   ```
   - Include dependencies (e.g., add `MariaDB/docker-compose.yml` and `Redis/docker-compose.yml` for Seafile).
   - For optional integrations, add their compose files (e.g., `SeaDoc/docker-compose.yml` if `ENABLE_SEADOC=true` in Seafile's config).

3. Review and customize environment variables in `.env` (e.g., domains, passwords, ports).
4. Check individual service READMEs for additional setup steps.

## Usage

### Starting Services

Start all configured services:
```sh
docker compose up -d
```

Start a specific service (e.g., Psono):
```sh
docker compose up -d psono
```

### Monitoring and Management

View logs:
```sh
docker compose logs -f [service_name]
```

Check status:
```sh
docker compose ps
```

### Stopping Services

Stop all services:
```sh
docker compose down
```

## Additional Notes

For detailed service configurations, refer to the README in each subdirectory.

---

Happy self-hosting! 🎉



