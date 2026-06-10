FROM caddy:builder-alpine AS builder

RUN xcaddy build \
    --with github.com/greenpau/caddy-security

# Stage 2: Create the final lightweight image
FROM caddy:alpine

# Copy the custom compiled binary from the builder stage
COPY --from=builder /usr/bin/caddy /usr/bin/caddy