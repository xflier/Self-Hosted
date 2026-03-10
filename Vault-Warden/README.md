# Vault-Warden Service

Vault-Warden (formerly Bitwarden_RS) is a lightweight, self-hosted password manager compatible with Bitwarden clients. It provides secure password storage, sharing, and generation with a clean web interface and mobile/desktop apps.

## Configuration

- **Image**: Specified by `VAULT_WARDEN_IMAGE` in the root `.env` file (default: `vaultwarden/server:latest`).
- **Container Name**: `vaultwarden`.
- **Network**: Attached to the shared `docker_net` network.
- **Restart Policy**: `unless-stopped` for automatic recovery.
- **Logging**: JSON format with 10MB max size, 3 files rotation.

### Environment Variables

Define these in the root `.env` file:

```env
VAULT_WARDEN_IMAGE=vaultwarden/server:latest
VAULT_WARDEN_SERVER_HOSTNAME=vaultwarden.example.com
SERVER_PROTOCOL=https
BASE_STORAGE_DIR=/blk
```

**Optional Environment Variables** (can be added to customize):

```env
SIGNUPS_ALLOWED=true  # Set to false after initial setup
ADMIN_TOKEN=<admin_token>  # For admin panel access
```

### Persistent Storage

Data is stored on the host at `${BASE_STORAGE_DIR:-/blk}/vault_warden`, mapped to `/data` in the container. This includes:

- User accounts and encrypted vaults
- Attachments and icons
- Configuration and logs

## Usage

1. Include `Vault-Warden/docker-compose.yml` in your `COMPOSE_FILE`.
2. Start the service:
   ```sh
   docker compose up -d vaultwarden
   ```
3. Access Vault-Warden at the configured hostname (e.g., `https://vaultwarden.example.com`).
4. Register an account and start using Bitwarden-compatible clients.

## Features

- **Bitwarden Compatibility**: Works with official Bitwarden apps and browser extensions.
- **End-to-End Encryption**: All data encrypted client-side.
- **Password Generator**: Built-in secure password creation.
- **Sharing**: Share passwords and secrets with other users.
- **Two-Factor Authentication**: Support for TOTP, YubiKey, and Duo.
- **Organizations**: Team features for shared vaults.
- **API**: RESTful API for integrations.
- **Attachments**: Store files alongside passwords.

## Client Setup

Download Bitwarden clients from the [official website](https://bitwarden.com/download/) and connect to your self-hosted instance:

1. In the client, go to Settings > Account > Self-hosted.
2. Enter your Vault-Warden URL: `https://vaultwarden.example.com`
3. Log in or create an account.

## Monitoring

- **Logs**: View with `docker compose logs -f vaultwarden`.
- **Admin Panel**: If `ADMIN_TOKEN` is set, access at `https://vaultwarden.example.com/admin`.
- **Health Check**: Basic health at `https://vaultwarden.example.com/alive`.

## Maintenance

- **Backups**: Regularly back up the `/data` volume.
- **Updates**: Pull new images with `docker compose pull vaultwarden`, then restart.
- **User Management**: Use the web interface or admin panel.
- **Security**: Keep `SIGNUPS_ALLOWED=false` after initial setup.

## Troubleshooting

- **Registration Disabled**: Check `SIGNUPS_ALLOWED` setting.
- **Login Issues**: Verify DOMAIN environment variable matches your URL.
- **SSL Problems**: Ensure Caddy is properly configured for HTTPS.
- **Performance**: Monitor resource usage; Vault-Warden is lightweight but may need more memory for large vaults.
- **Client Connection**: Confirm the client is configured with the correct server URL.

## Notes

- **Security**: Vault-Warden uses the same encryption as Bitwarden; server never sees plaintext passwords.
- **Migration**: Can import from other password managers or Bitwarden accounts.
- **Organizations**: Paid Bitwarden features like organizations are available in Vault-Warden.
- **Resource Usage**: Very lightweight; runs well on low-end hardware.
- **Community**: Actively maintained fork of the original Bitwarden_RS.

For more information, visit the [Vault-Warden GitHub repository](https://github.com/dani-garcia/vaultwarden).
