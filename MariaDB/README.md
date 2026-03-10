# MariaDB Service

MariaDB is a MySQL-compatible relational database server that serves as the backend for several applications in this self-hosted stack, such as Seafile.

## Configuration

- **Image**: Specified by `MARIA_DB_IMAGE` in `.env` (defaults to `mariadb:latest`).
- **Container Name**: `mariadb`.
- **Network**: Connected to the shared `docker_net` network for inter-service communication.
- **Health Check**: Ensures the database is operational before dependent services start.
- **Restart Policy**: `unless-stopped` for automatic recovery.

### Environment Variables

Define these in the root `.env` file:

```env
INIT_MARIA_ROOT_PASSWORD=<root password>
BASE_STORAGE_DIR=/blk            # or another host path
MARIA_DB_IMAGE=mariadb:latest    # image tag to use
```

> **Important**: `MARIADB_ROOT_PASSWORD` in the compose file is set via `INIT_MARIA_ROOT_PASSWORD`. Any changes here must be coordinated with services that connect to this database.

### Persistent Storage

Database files are persisted on the host at `${BASE_STORAGE_DIR:-/blk}/mariadb/db`, mapped to `/var/lib/mysql` in the container. This setup ensures data survives container restarts, updates, or recreations.

## Usage

1. Include `MariaDB/docker-compose.yml` in your `COMPOSE_FILE`.
2. Launch the service:
   ```sh
   docker compose up -d mariadb
   ```
3. Other services can connect using hostname `mariadb`, port 3306, with the root credentials.

## Maintenance

- **Backups**: Regularly dump databases using `mysqldump` or export the volume.
- **Updates**: Pull new images with `docker compose pull mariadb`, then restart.
- **Logs**: View with `docker compose logs -f mariadb`.
- **Customization**: Modify `docker-compose.yml` for tuning (e.g., memory limits), but ensure compatibility with dependent services.

## Troubleshooting

- **Connection Issues**: Verify `docker_net` network exists and credentials match.
- **Health Check Failures**: Check logs for initialization errors; may need to adjust timeouts.
- **Data Corruption**: Restore from backups if volume issues occur.

## Notes

- Auto-upgrade is enabled (`MARIADB_AUTO_UPGRADE=1`) for seamless schema updates.
- Console logging is active for easier debugging.

For advanced configuration, see the [official MariaDB Docker image docs](https://hub.docker.com/_/mariadb).
