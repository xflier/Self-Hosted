# PostgreSQL Service

PostgreSQL is a powerful, open-source relational database system used by several services in this self-hosted stack, such as Psono for password management.

## Configuration

- **Image**: Specified by `POSTGRES_IMAGE` in the root `.env` file (default: `postgres:17.9-alpine3.23`).
- **Container Name**: `postgres`.
- **Network**: Attached to the shared `docker_net` network.
- **Restart Policy**: `unless-stopped` for automatic recovery.
- **Shared Memory**: Set to 128MB for performance optimization.

### Environment Variables

Define these in the root `.env` file:

```env
POSTGRES_IMAGE=postgres:17.9-alpine3.23
POSTGRES_USER=postgres
POSTGRES_PASSWORD=<strong_root_password>
POSTGRES_DB=postgres
BASE_STORAGE_DIR=/blk
```

**key Variables**:
- `POSTGRES_USER`: Root username for the database.
- `POSTGRES_PASSWORD`: Root password (store securely in `.env`).
- `POSTGRES_DB`: Default database created at initialization.

### Initialization Script

The `init.sql` file in the PostgreSQL directory is run automatically on first startup. Use it to create additional databases and users for specific services:

```sql
create user <psono_user> with password '<psono_password>';
create database <psono_db> owner <psono_user>;
GRANT ALL PRIVILEGES ON DATABASE <psono_db> TO <psono_user>;
```

Replace placeholders with actual values from your `.env` file. This script runs only once; subsequent container starts do not re-execute it.

Copy the init.sql to ${BASE_STORAGE_DIR:?Variable is not set}/init/postgres and no need to manually run it.

### Persistent Storage

Database files are stored on the host at `${BASE_STORAGE_DIR:-/blk}/postgres`, mapped to `/var/lib/postgresql/data` in the container. This ensures data survives container recreation or upgrades.

The initialization scripts directory is at `${BASE_STORAGE_DIR:-/blk}/init/postgres`, mapped to `/docker-entrypoint-initdb.d` for SQL setup files.

## Usage

1. Include `PostgreSQL/docker-compose.yml` in your `COMPOSE_FILE` if a service requires it (e.g., Psono).
2. Update `init.sql` with the database and user configuration for your services.
3. Start the service:
   ```sh
   docker compose up -d postgres
   ```
4. Other containers can connect using hostname `postgres` on port 5432 with the credentials defined in `.env`.

## Integration with Psono

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

- **Init Script Not Running**: Ensure `init.sql` exists at `${BASE_STORAGE_DIR}/init/postgres/init.sql` before first startup; it only runs on container creation.

## Notes

- **Data Persistence**: Unlike ephemeral containers, PostgreSQL data survives restarts thanks to the volume mapping.
- **Port Exposure**: By default, port 5432 is not exposed to the host; services communicate via the Docker network.

For detailed documentation, visit the [official PostgreSQL Docker image page](https://hub.docker.com/_/postgres).
