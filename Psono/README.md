# Psono Password Manager

Psono is a secure, self-hosted password manager that supports sharing, emergency access, and team collaboration. It provides a web interface for managing passwords, files, and secrets with end-to-end encryption.

## Configuration

- **Image**: Defined by `PSONO_IMAGE` in the root `.env` file (default: `psono/psono-combo:latest`).
- **Container Name**: `psono`.
- **Network**: Attached to the shared `docker_net` network.
- **Restart Policy**: `unless-stopped` for automatic recovery.
- **Dependencies**: Requires PostgreSQL database.

### Environment Variables

Define these in the root `.env` file:

```env
PSONO_IMAGE=psono/psono-combo:latest
PSONO_SERVER_HOSTNAME=psono.example.com
SERVER_PROTOCOL=https
BASE_STORAGE_DIR=/blk
```

### Configuration Files

Psono uses two main configuration files mounted from the host:

1. **`config.json`** (mounted to `/usr/share/nginx/html/config.json` and `/usr/share/nginx/html/portal/config.json`):
   - Contains client-side configuration for the web interface.
   - Defines API endpoints, allowed domains, and feature flags.
   - Generate or customize based on your domain and settings.

2. **`settings.yaml`** (mounted to `/root/.psono_server/settings.yaml`):
   - Server-side configuration for the Django backend.
   - Includes database settings, secrets, email configuration, and feature toggles.
   - Requires generated secrets and domain-specific values.

### Database Setup

Psono requires PostgreSQL. Ensure PostgreSQL is running and configured with Psono's database credentials.

In PostgreSQL's `init.sql`, create the Psono database and user:

```sql
CREATE USER psono_user WITH PASSWORD '<psono_password>';
CREATE DATABASE psono_db OWNER psono_user;
GRANT ALL PRIVILEGES ON DATABASE psono_db TO psono_user;
```

Then set in `.env`:

```env
PSONO_DB_USER=psono_user
PSONO_DB_PASSWORD=<psono_password>
PSONO_DB_NAME=psono_db
```

### Secrets and Keys

Generate required secrets using Psono's key generation tools:

1. **Server Keys**: Run `docker run --rm psono/psono-combo:latest python3 ./psono/manage.py generateserverkeys` to generate:
   - `SECRET_KEY`
   - `ACTIVATION_LINK_SECRET`
   - `DB_SECRET`
   - `EMAIL_SECRET_SALT`
   - `PRIVATE_KEY`
   - `PUBLIC_KEY`

2. **Update `settings.yaml`** with the generated values.

### Email Configuration

Configure SMTP settings in `settings.yaml` for user activation and password recovery:

```yaml
EMAIL_FROM: 'your-email@example.com'
EMAIL_HOST: 'smtp.example.com'
EMAIL_HOST_USER: 'your-email@example.com'
EMAIL_HOST_PASSWORD: '<encrypted_password>'
EMAIL_PORT: 587
EMAIL_USE_TLS: True
```

### Client Configuration (config.json)

Update `config.json` with your domain and API endpoints. A basic example:

```json
{
  "backend_servers": [
    {
      "title": "Psono",
      "url": "https://psono.example.com/server"
    }
  ],
  "allow_registration": true,
  "allow_lost_password": true,
  "disable_central_security_reports": true
}
```

Adjust URLs and flags according to your `settings.yaml`.

### Persistent Storage

Configuration files are stored on the host at `${BASE_STORAGE_DIR:-/blk}/psono/`:
- `config.json`: Client configuration
- `settings.yaml`: Server settings

Ensure these files exist and are properly configured before starting the container.

## Usage

1. Set up PostgreSQL and generate secrets as described above.
2. Include `Psono/docker-compose.yml` and `PostgreSQL/docker-compose.yml` in your `COMPOSE_FILE`.
3. Start the service:
   ```sh
   docker compose up -d psono
   ```
4. Access Psono at the configured hostname (e.g., `https://psono.example.com`).
5. Register an admin account and begin managing passwords.

## Features

- **End-to-End Encryption**: All data encrypted client-side.
- **Sharing**: Share passwords and secrets with team members.
- **Emergency Access**: Grant temporary access to trusted contacts.
- **Multi-Factor Authentication**: Support for TOTP, YubiKey, and DUO.
- **API Access**: REST API for integrations.
- **File Storage**: Store encrypted files alongside passwords.

## Monitoring

- **Logs**: View with `docker compose logs -f psono`.
- **Health Check**: Access `https://psono.example.com/server/info/` for server status.
- **Database Connection**: Verify with `docker compose exec psono python3 ./psono/manage.py dbshell`.

## Maintenance

- **Backups**: Regularly back up PostgreSQL database and configuration files.
- **Updates**: Pull new images with `docker compose pull psono`, then restart.
- **User Management**: Use the web interface or API for user administration.
- **Cache Cleanup**: Run `docker compose exec psono python3 ./psono/manage.py cleartoken` periodically (see `bin/crontab.txt`).

## Troubleshooting

- **Registration Issues**: Check `ALLOWED_DOMAINS` in `settings.yaml` and email configuration.
- **Login Problems**: Verify secrets in `settings.yaml` are correctly generated and set.
- **Database Errors**: Ensure PostgreSQL is running and credentials match.
- **Email Not Sending**: Test SMTP settings and check firewall rules.
- **Performance Issues**: Monitor resource usage; consider enabling Redis caching if available.

## Notes

- **Security**: Psono uses client-side encryption; server-side secrets are for session management only.
- **Registration**: Can be disabled by setting `ALLOW_REGISTRATION: False` in `settings.yaml`.
- **Lost Password**: Can be disabled with `ALLOW_LOST_PASSWORD: False`.
- **Cache**: Redis caching can be enabled for improved performance (requires Redis service).
- **Proxies**: `NUM_PROXIES: 2` accounts for Caddy and internal proxy; adjust for additional load balancers.

For detailed documentation, visit the [official Psono website](https://psono.com/) and [GitHub repository](https://github.com/psono/psono-ce).
