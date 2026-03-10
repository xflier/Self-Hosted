# SeaDoc Service

SeaDoc is a collaborative document editing service that integrates with Seafile to provide real-time, web-based editing of rich text documents (`.sdoc` format). It enables multiple users to edit documents simultaneously with changes synced instantly, offering a more advanced editing experience than basic Markdown.

## Configuration

- **Image**: Defined by `SEADOC_IMAGE` in the root `.env` file (default: `seafileltd/sdoc-server:2.0-latest`).
- **Container Name**: `seadoc`.
- **Network**: Attached to the shared `docker_net` network.
- **Restart Policy**: `unless-stopped` for automatic recovery.
- **Dependencies**: Requires MariaDB database (shared with Seafile).

### Environment Variables

Define these in the root `.env` file:

```env
SEADOC_IMAGE=seafileltd/sdoc-server:2.0-latest
MARIA_DB_HOST=mariadb
MARIA_DB_PORT=3306
SEAFILE_DB_USER=<seafile_db_user>
SEAFILE_DB_PASSWORD=<seafile_db_password>
SEAFILE_SEAHUB_DB_NAME=<seahub_db_name>
TIME_ZONE=America/New_York
JWT_PRIVATE_KEY=<jwt_secret>
NON_ROOT=false
SEAFILE_SERVER_HOSTNAME=<seafile_domain>
SERVER_PROTOCOL=https
BASE_STORAGE_DIR=/blk
```

**Note**: SeaDoc shares the same database and JWT secret as Seafile for seamless integration.

### Persistent Storage

Data is stored on the host at `${BASE_STORAGE_DIR:-/blk}/seadoc`, mapped to `/shared` in the container. This includes document files and collaboration data.

## Integration with Seafile

SeaDoc is an optional add-on for Seafile that provides advanced document editing capabilities:

1. Ensure Seafile is running and configured.
2. Enable SeaDoc in Seafile's environment:
   ```env
   ENABLE_SEADOC=true
   SEADOC_SERVER_URL=https://<seafile_domain>/sdoc-server
   ```
3. Include `SeaDoc/docker-compose.yml` in your `COMPOSE_FILE` alongside Seafile and MariaDB.
4. Restart Seafile after enabling.

Once integrated, users can open Office documents in Seafile and edit them collaboratively in SeaDoc.

## Usage

1. Set up MariaDB and Seafile first.
2. Include `SeaDoc/docker-compose.yml` in your `COMPOSE_FILE`.
3. Start the service:
   ```sh
   docker compose up -d seadoc
   ```
4. SeaDoc will be accessible through Seafile's interface at `/sdoc-server`.

## Troubleshooting

- **Documents Not Opening**: Check that `ENABLE_SEADOC=true` in Seafile and SeaDoc is running.
- **Connection Errors**: Verify MariaDB is accessible and credentials match Seafile's.
- **WebSocket Issues**: Ensure Caddy labels are correct and firewall allows WebSocket traffic.
- **JWT Mismatches**: Confirm `JWT_PRIVATE_KEY` is identical in both Seafile and SeaDoc configs.
- **Path Routing**: SeaDoc routes through `/sdoc-server`; check Caddy configuration for proper forwarding.

## Notes

- **Dependency on Seafile**: SeaDoc requires Seafile to function; it cannot run standalone.
- **Database Sharing**: Uses the same MariaDB database as Seafile (`SEAFILE_SEAHUB_DB_NAME`).
- **WebSocket Routing**: Caddy labels handle WebSocket upgrades and path rewriting for real-time features.
- **Resource Usage**: Collaborative editing may increase memory and CPU usage.

For more information, visit the [SeaDoc GitHub repository](https://github.com/haiwen/seadoc) and [Seafile documentation](https://manual.seafile.com/).
