#!/usr/bin/env bash

set -e

source /etc/profile.d/secrets-to-env-vars.sh

if [ "$(mysql -h "$DATABASE_HOST" -u "$DATABASE_USER" -p"$(cat /run/secrets/database-password)" \
      -sse "select count(*) from information_schema.tables where table_schema='pimcore' and table_name='assets';")" -eq 0 ] \
   && [ "$PIMCORE_INSTALL" = "true" ]
then
  echo "Database is empty and PIMCORE_INSTALL is set to true, so calling pimcore-install..."
  export PIMCORE_INSTALL_ENCRYPTION_SECRET=$PIMCORE_ENCRYPTION_SECRET
  export PIMCORE_INSTALL_INSTANCE_IDENTIFIER=$PIMCORE_INSTANCE_IDENTIFIER
  export PIMCORE_INSTALL_PRODUCT_KEY=$PIMCORE_PRODUCT_KEY
  export PIMCORE_INSTALL_MYSQL_HOST_SOCKET=$DATABASE_HOST
  export PIMCORE_INSTALL_MYSQL_PORT=$DATABASE_PORT
  export PIMCORE_INSTALL_MYSQL_USERNAME=$DATABASE_USER
  export PIMCORE_INSTALL_MYSQL_DATABASE=$DATABASE_NAME
  export PIMCORE_INSTALL_ADMIN_USERNAME=admin
  export PIMCORE_INSTALL_MYSQL_PASSWORD=$(cat /run/secrets/database-password)
  export PIMCORE_INSTALL_ADMIN_PASSWORD=$(cat /run/secrets/pimcore-admin-password)
  runuser -u www-data -- vendor/bin/pimcore-install --skip-database-config --no-interaction
fi

echo Installing bundles...
/install-bundles.sh

echo Running migration...
runuser -u www-data -- /var/www/html/bin/console doctrine:migrations:migrate -n

echo Rebuilding classes...
runuser -u www-data -- /var/www/html/bin/console pimcore:deployment:classes-rebuild -c -d -n --force

echo Creating folders...
runuser -u www-data -- /var/www/html/bin/console torq:folder-creator

echo Generating roles...
runuser -u www-data -- /var/www/html/bin/console torq:generate-roles

echo Rebuilding class definitions for indexes...
if [ ! -f /var/www/html/var/installer/.index-complete ]; then
  echo "Fresh install detected, running full index rebuild..."
  runuser -u www-data -- /var/www/html/bin/console generic-data-index:update:index -r
  touch /var/www/html/var/installer/.index-complete
else
  runuser -u www-data -- /var/www/html/bin/console generic-data-index:update:index --update-global-aliases-only
  runuser -u www-data -- /var/www/html/bin/console generic-data-index:deployment:reindex
  runuser -u www-data -- /var/www/html/bin/console generic-data-index:reindex
fi

echo Clearing Pimcore cache...
runuser -u www-data -- /var/www/html/bin/console pimcore:cache:clear

echo Generating quantity values...
runuser -u www-data -- /var/www/html/bin/console definition:import:units config/quantityvalues.json --override
