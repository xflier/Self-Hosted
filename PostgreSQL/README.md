# PostgreSQL Service

PostgreSQL is a powerful, open-source relational database system used by several services in this self-hosted stack, such as Psono for password management.

## Configuration

- **Image**: Defined by `POSTGRES_IMAGE` in the root `.env` file.
- **Container name**: `postgres`
- **User**: Uses `${UID:-0}:${GID:-0}` to keep file ownership aligned with the host user when available.
- **Restart policy**: `unless-stopped`
- **Shared memory**: `128mb`
- **Network**: Attached to external `docker_net`
- **Host port exposure**: None by default; the container is intended to be accessed via Docker networking.

### Environment variables

Define these variables in the root `.env` file:

```env
POSTGRES_IMAGE=postgres:17.9-alpine3.23
POSTGRES_USER=postgres
POSTGRES_PASSWORD=<strong_root_password>
POSTGRES_DB=postgres
BASE_STORAGE_DIR=/blk
```

Key variables:

- `POSTGRES_IMAGE`: PostgreSQL container image.
- `POSTGRES_USER`: Database superuser name.
- `POSTGRES_PASSWORD`: Database superuser password.
- `POSTGRES_DB`: Default database created when the container initializes.

### Initialization script

The compose stack mounts `${BASE_STORAGE_DIR}/init/postgres` to `/docker-entrypoint-initdb.d`. Any `.sql` or `.sh` file in that directory is executed when the container initializes for the first time.

If you want to create service-specific users and databases, create an `init.sql` file and place it at `${BASE_STORAGE_DIR}/init/postgres` before the first run:

```sql
create user <psono_user> with password '<psono_password>';
create database <psono_db> owner <psono_user>;
GRANT ALL PRIVILEGES ON DATABASE <psono_db> TO <psono_user>;
```

Replace placeholders with actual values from your `.env` file. This script runs only once; subsequent container starts do not re-execute it.

Place the file at `${BASE_STORAGE_DIR:-/blk}/init/postgres` — it runs automatically on container creation.

### Persistent Storage

Database files are stored on the host at `${BASE_STORAGE_DIR:-/blk}/postgres`, mapped to `/var/lib/postgresql/data` in the container. This ensures data survives container recreation or upgrades.

The initialization scripts directory is at `${BASE_STORAGE_DIR:-/blk}/init/postgres`, mapped to `/docker-entrypoint-initdb.d` for SQL setup files.

## Usage

1. Include `PostgreSQL/docker-compose.yml` in your `COMPOSE_FILE` if a service requires it (e.g., Psono).
2. Create and place `init.sql` at `${BASE_STORAGE_DIR}/init/postgres` with your database and user configuration.
3. Start the service:
   ```sh
   docker compose up -d postgres
   ```
4. Other containers can connect using hostname `postgres` on port 5432 with the credentials defined in `.env`.

## Psono integration

Psono uses PostgreSQL as its backend. To configure:

1. Define Psono database credentials in `.env`:
   ```env
   PSONO_DB_USER=psono_user
   PSONO_DB_PASSWORD=<psono_password>
   PSONO_DB_NAME=psono_db
   ```

2. Update `init.sql` to match:
   ```sql
   create user psono_user with password '<psono_password>';
   create database psono_db owner psono_user;
   GRANT ALL PRIVILEGES ON DATABASE psono_db TO psono_user;
   ```

3. Include `PostgreSQL/docker-compose.yml` in `COMPOSE_FILE` before starting Psono.

## Troubleshooting

- **Init Script Not Running**: Ensure the SQL file is placed at `${BASE_STORAGE_DIR}/init/postgres` before container creation; init scripts only run once.

## Notes

- Services should connect to PostgreSQL via the Docker network, not through a published host port.
- The container is configured for internal service communication in the self-hosted stack.

For detailed documentation, visit the [official PostgreSQL Docker image page](https://hub.docker.com/_/postgres).
