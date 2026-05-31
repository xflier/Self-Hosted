# GitLab

Docker Compose setup for self-hosted GitLab and an optional GitLab Runner.

## Overview

This directory contains:

- `gitlab`: GitLab Omnibus application.
- `gitlab-runner`: GitLab Runner for CI/CD jobs.

The stack uses an external Docker network named `docker_net` and expects HTTP traffic to be terminated by a reverse proxy.

## Prerequisites

- Docker Engine and Docker Compose v2.
- External Docker network:

```sh
docker network create docker_net
```

- A repository root `.env` file or exported environment variables for Docker Compose.

## Required environment variables

Set the following variables before starting the stack:

- `GITLAB_IMAGE`: GitLab Omnibus Docker image.
- `GITLAB_RUNNER_IMAGE`: GitLab Runner image.
- `GITLAB_SERVER_HOSTNAME`: hostname for GitLab access, e.g. `gitlab.example.com`.
- `GITLAB_PORT`: (optional) host HTTP port to map to container port `80` if you choose to publish the web UI directly instead of using a reverse proxy. This port mapping is commented out by default in `docker-compose.yml`.
- `GITLAB_ROOT_EMAIL`: root user email.
- `GITLAB_ROOT_PASSWD`: root password (minimum 12 characters).
- `SERVER_PROTOCOL`: protocol used by the proxy, e.g. `https`.
- `BASE_STORAGE_DIR`: host base path for persistent storage.

## Storage layout

Persistent data is stored under:

- `${BASE_STORAGE_DIR}/gitlab/config`
- `${BASE_STORAGE_DIR}/gitlab/data`
- `${BASE_STORAGE_DIR}/gitlab/logs`
- `${BASE_STORAGE_DIR}/gitlab/runner-config`
- `/var/run/docker.sock:/var/run/docker.sock` for `gitlab-runner` to operate Docker jobs.

## Start the stack

From the `Gitlab/..` repo root directory:

```sh
docker compose up -d gitlab gitlab-runner
```

If you launch from the repo root, include `Gitlab/docker-compose.yml` in `COMPOSE_FILE`.

## Access

- Web UI: `http://${GITLAB_SERVER_HOSTNAME}` or `https://${GITLAB_SERVER_HOSTNAME}` depending on proxy configuration. The compose file does not expose port `80` on the host by default.
- Git SSH: host port `2222` → container port `22`.

## GitLab Runner registration

Register the runner with:

```sh
docker compose exec gitlab-runner gitlab-runner register
```

When prompted for the GitLab URL, use the internal service address:

```text
http://gitlab
```

If you need to force the runner clone URL, add the following under each `[[runners]]` section in `${BASE_STORAGE_DIR}/gitlab/runner-config/config.toml`:

```toml
clone_url = "http://gitlab"
```

## Common commands

```sh
# Start GitLab services under repo root
docker compose up -d gitlab

# View GitLab logs
docker compose logs -f gitlab

# Stop services
docker compose down gitlab
```

## Troubleshooting

- Ensure the external network `docker_net` exists.
- Verify that `GITLAB_SERVER_HOSTNAME` resolves to the server IP.
- Confirm `GITLAB_ROOT_PASSWD` meets GitLab Omnibus strength requirements.
- Check Caddy proxy labels and reverse proxy configuration if HTTP/HTTPS access fails.
