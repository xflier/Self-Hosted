#!/bin/sh
# Merge system CA bundle with Caddy root CA so Python's requests library
# trusts both real SSL certificates and Caddy's internal CA.
cat /etc/ssl/certs/ca-certificates.crt /usr/local/share/ca-certificates/caddy_root.crt > /combined-ca.crt

# Continue with the original container startup
exec /bin/sh /root/configs/docker/cmd.sh
