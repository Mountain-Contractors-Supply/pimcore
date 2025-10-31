#!/bin/bash
source /etc/profile.d/secrets-to-env-vars.sh
exec "/usr/local/bin/entrypoint.sh" php-fpm