# OnlyOffice Document Server

OnlyOffice is a powerful online document editing and collaboration platform that supports Office Open XML formats (`.docx`, `.xlsx`, `.pptx`). In this setup, it serves as a document editor integrated with Seafile, allowing users to edit files directly from the file-sharing platform.

## Configuration

- **Image**: Defined by `ONLYOFFICE_IMAGE` in the root `.env` file (default: `onlyoffice/documentserver:latest`).
- **Container Name**: `onlyoffice`.
- **Database**: MariaDB for storing document metadata and collaboration data.
- **Network**: Attached to the shared `docker_net` network.
- **Restart Policy**: `unless-stopped` for automatic recovery.

### Environment Variables

Define these in the root `.env` file:

```env
ONLYOFFICE_IMAGE=onlyoffice/documentserver:latest
ONLYOFFICE_SERVER_HOSTNAME=onlyoffice.example.com
MARIA_DB_HOST=mariadb
MARIA_DB_PORT=3306
ONLYOFFICE_DB_USER=onlyoffice_user
ONLYOFFICE_DB_PASSWORD=<strong_password>
ONLYOFFICE_DB_NAME=onlyoffice_db
JWT_PRIVATE_KEY=<your_jwt_secret>
SERVER_PROTOCOL=https
```

> **Note**: `JWT_PRIVATE_KEY` must match the same value used in Seafile and other services for secure inter-service communication. Generate a strong random string (e.g., using `pwgen -s 40 1`).

**Key Features**:
- **WOPI Support**: Enabled for integration with file-sharing platforms (Seafile).
- **JWT Security**: Enabled for secure document requests between services.
- **DB Type**: MariaDB is required for data persistence.
- **IP Allow Lists**: Set to allow private and meta IP addresses for internal communication.

### Database Setup

Before starting OnlyOffice, ensure:

1. MariaDB is running and accessible.
2. Create the OnlyOffice database and user:
   ```sql
   CREATE DATABASE onlyoffice_db;
   CREATE USER 'onlyoffice_user'@'onlyoffice' IDENTIFIED BY '<password>';
   GRANT ALL PRIVILEGES ON onlyoffice_db.* TO 'onlyoffice_user'@'onlyoffice';
   FLUSH PRIVILEGES;
   ```

3. Update the `.env` with matching credentials.

### Persistent Storage

Multiple volumes store application data:

- `${BASE_STORAGE_DIR:-/blk}/onlyoffice/logs`: Server logs.
- `${BASE_STORAGE_DIR:-/blk}/onlyoffice/data`: Application data and configuration.
- `${BASE_STORAGE_DIR:-/blk}/onlyoffice/lib`: Library and state files.
- `${BASE_STORAGE_DIR:-/blk}/onlyoffice/examples`: Example document files.
- `${BASE_STORAGE_DIR:-/blk}/onlyoffice/fonts`: Custom fonts.
- `${BASE_STORAGE_DIR:-/blk}/onlyoffice/caches`: Document caches.

## Integration with Seafile

OnlyOffice can be integrated with Seafile to provide in-browser document editing directly from the file manager:

1. Ensure OnlyOffice is running and accessible via `https://onlyoffice.example.com`.
2. Include `OnlyOffice/docker-compose.yml` in your `COMPOSE_FILE` alongside Seafile.
3. In Seafile's environment variables, set:
   ```env
   ENABLE_ONLYOFFICE=true
   ONLYOFFICE_ENDPOINT=https://onlyoffice.example.com
   ONLYOFFICE_JWT_SECRET=<same_jwt_private_key_as_above>
   ```
4. Restart Seafile for the changes to take effect.
5. Users can now open `.docx`, `.xlsx`, and `.pptx` files directly in OnlyOffice from Seafile.

## Usage

1. Include `OnlyOffice/docker-compose.yml` in your `COMPOSE_FILE`.
2. Ensure MariaDB is also in the compose file (dependency).
3. Start the service:
   ```sh
   docker compose up -d onlyoffice
   ```
4. Access the service at the configured hostname (e.g., `https://onlyoffice.example.com`).

## Monitoring

- **Logs**: View with `docker compose logs -f onlyoffice`.
- **Database Connection**: Verify with `docker compose exec onlyoffice mysql -h mariadb -u onlyoffice_user -p`.
- **Health**: The service may take a minute to initialize on first start.

## Maintenance

- **Backups**: Regularly back up the MariaDB database and the volumes in `${BASE_STORAGE_DIR}/onlyoffice`.
- **Updates**: Change the image version in `.env` and run `docker compose pull && docker compose up -d onlyoffice`.
- **Cache Cleanup**: Clear caches periodically to preserve disk space:
  ```bash
  docker compose exec onlyoffice rm -rf /var/lib/onlyoffice/documentserver/App_Data/cache/files/*
  ```

## Troubleshooting

- **Connection Error**: Ensure MariaDB is healthy and credentials match.
- **JWT Issues**: Verify `JWT_SECRET` in OnlyOffice matches `JWT_PRIVATE_KEY` in Seafile and `.env`.
- **Performance**: Monitor memory and CPU; increase container resources if needed.
- **Document Not Opening**: Check Caddy logs and ensure the hostname is properly configured.

## Notes

- Grace period for shutdown is set to 60 seconds to allow graceful document saves.
- WOPI protocol enables deep integration with file managers like Seafile.
- Commented options like RabbitMQ and unauthorized storage can be enabled if needed.

For more details, visit the [official OnlyOffice documentation](https://helpcenter.onlyoffice.com/).
