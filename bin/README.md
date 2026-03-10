# Maintenance Scripts

This directory contains maintenance utilities for the self-hosted services, primarily cron jobs for automated upkeep tasks.

## Files

- **`crontab.txt`**: Sample crontab entries for scheduled maintenance tasks.

## Scheduled Tasks

The provided crontab includes the following daily jobs (running at 3:30 AM):

1. **Psono Token Cleanup**:
   ```bash
   30 3 * * * /usr/bin/docker exec psono python3 ./psono/manage.py cleartoken > /tmp/cron.log
   ```
   - Purpose: Removes expired authentication tokens from the Psono database to maintain performance and security.
   - Logs output to `/tmp/cron.log` on the host.

2. **Seafile Garbage Collection**:
   ```bash
   30 3 * * * docker exec seafile sh -c 'exec /opt/seafile/seafile-server-latest/seaf-gc.sh --rm-fs >> /tmp/seaf-gc.log'
   ```
   - Purpose: Cleans up unused files and data in Seafile to free up storage space.
   - Logs output to `/tmp/seaf-gc.log` on the host.

## Installation

To install these cron jobs on your system:

1. Ensure the services (Psono, Seafile) are running and accessible via `docker compose up -d`.
2. Review and edit `crontab.txt` if needed (e.g., adjust paths, times, or add user context).
3. Install the crontab:
   ```bash
   crontab crontab.txt
   ```
   Or append to existing crontab:
   ```bash
   crontab -l | cat - crontab.txt | crontab -
   ```

## Prerequisites

- Cron daemon installed and running on the host.
- Services must be running for the commands to succeed.

## Notes

- Adjust the schedule times in `crontab.txt` to suit specific needs.
- Monitor log files (`/tmp/cron.log`, `/tmp/seaf-gc.log`) for execution status and errors.
- Ensure log directories exist or update paths as necessary.
- These tasks are optional but recommended for long-term maintenance of the services.
