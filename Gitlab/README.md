# GitLab

Self-hosted GitLab with an optional GitLab Runner for CI/CD.

## Services

- `gitlab`: GitLab Omnibus application
- `gitlab-runner`: GitLab Runner

## Prerequisites

- Docker Engine and Docker Compose v2
- `docker_net` external Docker network
- Root `.env` file with required variables

## Required variables

- `GITLAB_IMAGE`
- `GITLAB_RUNNER_IMAGE`
- `GITLAB_SERVER_HOSTNAME`
- `GITLAB_ROOT_EMAIL`
- `GITLAB_ROOT_PASSWD`
- `SERVER_PROTOCOL`
- `BASE_STORAGE_DIR`

## Service details

- `gitlab` publishes host port `2222` to container port `22`
- The web UI is served internally on port `80`
- Caddy labels are defined for proxying HTTP traffic to the GitLab hostname
- The runner uses `/var/run/docker.sock` and `${BASE_STORAGE_DIR}/gitlab/runner-config`

## Start

```sh
docker compose -f Gitlab/docker-compose.yml up -d
```

## Access

- Web UI: `https://${GITLAB_SERVER_HOSTNAME}` (via reverse proxy)
- SSH: `ssh -p 2222 git@<host>`
