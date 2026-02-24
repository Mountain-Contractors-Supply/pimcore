#!/bin/sh
set -eu

if [ -f /run/secrets/mercure-jwt ]; then
  MERCURE_JWT=$(tr -d '\r' < /run/secrets/mercure-jwt 2>/dev/null | sed -e 's/[[:space:]]*$//')
else
  MERCURE_JWT=""
fi

export MERCURE_PUBLISHER_JWT_KEY="${MERCURE_PUBLISHER_JWT_KEY:-$MERCURE_JWT}"
export MERCURE_SUBSCRIBER_JWT_KEY="${MERCURE_SUBSCRIBER_JWT_KEY:-$MERCURE_JWT}"

exec caddy run --config /etc/caddy/Caddyfile --adapter caddyfile