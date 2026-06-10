# Maintenance Scripts

This directory contains sample maintenance cron jobs for long-term upkeep of the self-hosted stack.

## Files

- `crontab.txt`: example cron entries for scheduled tasks.

## Included tasks

- **Psono token cleanup**: removes expired Psono authentication tokens.
- **Seafile garbage collection**: cleans up unused Seafile file storage.

## Install

1. Review `crontab.txt` and adjust paths or schedules as needed.
2. Install the file as the target user:
   ```sh
crontab crontab.txt
```

Or append to an existing crontab:

```sh
crontab -l | cat - crontab.txt | crontab -
```

## Notes

- Ensure the target services are running before the cron jobs execute.
- Monitor the log files configured in `crontab.txt`.
