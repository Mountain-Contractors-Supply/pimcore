#!/bin/sh
set -eu

SECRET_FILE="/run/secrets/opensearch-initial-admin-password"

if [ -f "$SECRET_FILE" ]; then
  OPENSEARCH_INITIAL_ADMIN_PASSWORD=$(tr -d '\r' < "$SECRET_FILE" 2>/dev/null | sed -e 's/[[:space:]]*$//')
else
  OPENSEARCH_INITIAL_ADMIN_PASSWORD="${OPENSEARCH_INITIAL_ADMIN_PASSWORD:-}"
fi

export OPENSEARCH_INITIAL_ADMIN_PASSWORD

exec ./opensearch-docker-entrypoint.sh "$@"