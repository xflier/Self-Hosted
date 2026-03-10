# Seafile Service

Seafile is a powerful, open-source file syncing and sharing platform that provides Dropbox-like functionality with advanced features like version control, encryption, and collaborative editing. It supports both file syncing and team collaboration with a web interface.

## Configuration

- **Image**: Defined by `SEAFILE_IMAGE` in the root `.env` file (default: `seafileltd/seafile-mc:13.0-latest`).
- **Container Name**: `seafile`.
- **Network**: Attached to the shared `docker_net` network.
- **Restart Policy**: `unless-stopped` for automatic recovery.
- **Dependencies**: Requires MariaDB (healthy) and Redis (started).

### Environment Variables

Define these in the root `.env` file:

```env
SEAFILE_IMAGE=seafileltd/seafile-mc:13.0-latest
SEAFILE_SERVER_HOSTNAME=seafile.example.com
SERVER_PROTOCOL=https
MARIA_DB_HOST=mariadb
MARIA_DB_PORT=3306
SEAFILE_DB_USER=seafile_user
SEAFILE_DB_PASSWORD=<db_password>
SEAFILE_CCNET_DB_NAME=ccnet_db
SEAFILE_DB_NAME=seafile_db
SEAFILE_SEAHUB_DB_NAME=seahub_db
MARIA_ROOT_PASSWORD=<root_password>
INIT_SEAFILE_ADMIN_EMAIL=admin@example.com
INIT_SEAFILE_ADMIN_PASSWORD=<admin_password>
TIME_ZONE=America/New_York
SITE_ROOT=/
NON_ROOT=false
JWT_PRIVATE_KEY=<jwt_secret>
SEAFILE_LOG_TO_STDOUT=true
ENABLE_SEADOC=false
ENABLE_GO_FILESERVER=true
CACHE_PROVIDER=redis
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=<redis_password>
BASE_STORAGE_DIR=/blk
```

### Database Setup

Seafile requires MariaDB. Ensure the database is created before starting:

The MariaDB init.sql should include:

```sql
CREATE DATABASE ccnet_db;
CREATE DATABASE seafile_db;
CREATE DATABASE seahub_db;
CREATE USER 'seafile_user'@'seafile' IDENTIFIED BY '<password>';
GRANT ALL PRIVILEGES ON ccnet_db.* TO 'seafile_user'@'seafile';
GRANT ALL PRIVILEGES ON seafile_db.* TO 'seafile_user'@'seafile';
GRANT ALL PRIVILEGES ON seahub_db.* TO 'seafile_user'@'seafile';
FLUSH PRIVILEGES;
```

### Persistent Storage

Data is stored on the host at `${BASE_STORAGE_DIR:-/blk}/seafile`, mapped to `/shared` in the container. This includes:

- Configuration files
- User data and libraries
- Logs and cache

### Initial Setup

After first startup, you may need to:

1. **Enable WebDAV**: Edit `/blk/seafile/seafile/conf/seafdav.conf` and set:
   ```ini
   [WEBDAV]
   enabled = true
   ```

2. **Configure Seahub Settings**: Update `seahub_settings.py` for integrations (see below).

## Integrations

### OnlyOffice Integration

To enable document editing with OnlyOffice:

1. Ensure OnlyOffice is running.
2. Update `seahub_settings.py`:
   ```python
   ENABLE_ONLYOFFICE = True
   VERIFY_ONLYOFFICE_CERTIFICATE = False
   ONLYOFFICE_FORCE_SAVE = True
   ONLYOFFICE_INTERNAL_URL = 'http://onlyoffice/'
   ONLYOFFICE_APIJS_URL = 'https://<onlyoffice_domain>/web-apps/apps/api/documents/api.js'
   ONLYOFFICE_JWT_SECRET = '<jwt_private_key>'
   ```
3. Restart Seafile.

### SeaDoc Integration

For collaborative rich text editing:

1. Set `ENABLE_SEADOC=true` in `.env`.
2. Ensure SeaDoc service is running.
3. SeaDoc will be available at `/sdoc-server`.

### Caching

Seafile uses Redis for caching by default. Ensure Redis is running and configured.

## Usage

1. Set up MariaDB and Redis.
2. Include `Seafile/docker-compose.yml`, `MariaDB/docker-compose.yml`, and `Redis/docker-compose.yml` in `COMPOSE_FILE`.
3. Start the services:
   ```sh
   docker compose up -d seafile
   ```
4. Access Seafile at the configured hostname.
5. Log in with the admin credentials from `INIT_SEAFILE_ADMIN_EMAIL` and `INIT_SEAFILE_ADMIN_PASSWORD`.

## Features

- **File Syncing**: Client apps for desktop and mobile.
- **Version Control**: Track file changes and restore previous versions.
- **Sharing**: Share files and folders with users or via public links.
- **Encryption**: Client-side encryption for sensitive data.
- **WebDAV**: Mount as network drive.
- **API**: REST API for integrations.
- **Extensions**: Support for OnlyOffice and SeaDoc.

## Monitoring

- **Logs**: View with `docker compose logs -f seafile`.
- **Web Interface**: Access admin panel at `/sysadmin/` with admin credentials.
- **Database**: Monitor MariaDB connections and performance.

## Maintenance

- **Backups**: Regularly back up `/shared` volume and MariaDB databases.
- **Updates**: Pull new images with `docker compose pull seafile`, then restart.
- **User Management**: Use web interface for user administration.
- **Storage Cleanup**: Run garbage collection periodically (see `bin/crontab.txt`).

## Troubleshooting

- **Database Connection**: Ensure MariaDB is healthy and credentials match.
- **Redis Issues**: Verify Redis is running and `CACHE_PROVIDER` is set correctly.
- **WebDAV Not Working**: Check `seafdav.conf` and Caddy routing.
- **Integration Problems**: Confirm JWT secrets match between services.
- **Performance**: Monitor resource usage; increase limits if needed.

## Notes

- **First Run**: May take time to initialize databases and create admin user.
- **Security**: Change default admin password after first login.
- **Scaling**: For high usage, consider separate database server.
- **Client Apps**: Download from [Seafile website](https://www.seafile.com/download/).
- **Community Edition**: This setup uses the community edition; enterprise features require paid version.

For detailed documentation, visit the [official Seafile manual](https://manual.seafile.com/).
