#!/usr/bin/env bash

set -e

source /etc/profile.d/secrets-to-env-vars.sh

/composer-install-dependencies.sh

if [ "$(mysql -h "$DATABASE_HOST" -u "$DATABASE_USER" -p"$(cat /run/secrets/database-password)" \
      -sse "select count(*) from information_schema.tables where table_schema='pimcore' and table_name='assets';")" -ne 0 ]
then
    # Only run cache clear if the database is seeded. If it is not, trying to clear the cache will cause errors.
    # init.sh will handle seeding it
    PHP_MEMORY_LIMIT=-1 runuser -u www-data -- bin/console cache:clear
fi

# Install assets via Tailwind and AssetMapper (done here so local public/ folder is populated)
runuser -u www-data -- /var/www/html/bin/console tailwind:build
runuser -u www-data -- /var/www/html/bin/console importmap:install
runuser -u www-data -- /var/www/html/bin/console asset-map:compile

/init.sh
