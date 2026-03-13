#!/usr/bin/env bash

set -e

source /etc/profile.d/secrets-to-env-vars.sh

if [ "$(mysql -h "$DATABASE_HOST" -u "$DATABASE_USER" -p"$DATABASE_PASSWORD" \
      -sse "select count(*) from information_schema.tables where table_schema='pimcore' and table_name='assets';")" -eq 0 ] \
   && [ "$PIMCORE_INSTALL" = "true" ]
then
  echo "Database is empty and PIMCORE_INSTALL is set to true, so calling pimcore-install..."
  PIMCORE_INSTALL_ENCRYPTION_SECRET=$PIMCORE_ENCRYPTION_SECRET \
  PIMCORE_INSTALL_INSTANCE_IDENTIFIER=$PIMCORE_INSTANCE_IDENTIFIER \
  PIMCORE_INSTALL_PRODUCT_KEY=$PIMCORE_PRODUCT_KEY \  
  PIMCORE_INSTALL_MYSQL_HOST_SOCKET=$DATABASE_HOST \
  PIMCORE_INSTALL_MYSQL_PORT=$DATABASE_PORT \
  PIMCORE_INSTALL_MYSQL_USERNAME=$DATABASE_USER \
  PIMCORE_INSTALL_MYSQL_DATABASE=$DATABASE_NAME \
  PIMCORE_INSTALL_ADMIN_USERNAME=admin \
  PIMCORE_INSTALL_MYSQL_PASSWORD=$(cat /run/secrets/database-password) \
  PIMCORE_INSTALL_ADMIN_PASSWORD=$(cat /run/secrets/pimcore-admin-password) \

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

echo Clearing Pimcore cache...
runuser -u www-data -- /var/www/html/bin/console pimcore:cache:clear

echo Generating quantity values...
runuser -u www-data -- /var/www/html/bin/console definition:import:units config/quantityvalues.json --override
