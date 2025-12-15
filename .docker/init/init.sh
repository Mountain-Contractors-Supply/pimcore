#!/usr/bin/env bash

set -e

source /etc/profile.d/secrets-to-env-vars.sh

if [ "$(mysql -h "$DATABASE_HOST" -u "$DATABASE_USER" -p"$DATABASE_PASSWORD" \
      -sse "select count(*) from information_schema.tables where table_schema='pimcore' and table_name='assets';")" -eq 0 ] \
   && [ "$PIMCORE_INSTALL" = "true" ]
then
  echo "Database is empty and PIMCORE_INSTALL is set to true, so calling pimcore-install..."
  runuser -u www-data -- vendor/bin/pimcore-install --skip-database-config --no-interaction
fi

echo Installing bundles...
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreAdminBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreApplicationLoggerBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreCustomReportsBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreGlossaryBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreSeoBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreSimpleBackendSearchBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreStaticRoutesBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreUuidBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreXliffBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreWordExportBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreDataHubBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcoreDataImporterBundle --no-cache-clear
runuser -u www-data -- /var/www/html/bin/console pimcore:bundle:install PimcorePerspectiveEditorBundle

echo Running migration...
runuser -u www-data -- /var/www/html/bin/console doctrine:migrations:migrate -n

echo Rebuilding classes...
runuser -u www-data -- /var/www/html/bin/console pimcore:deployment:classes-rebuild -c -d -n --force

echo Creating folders...
runuser -u www-data -- /var/www/html/bin/console torq:folder-creator

echo Generating roles...
runuser -u www-data -- /var/www/html/bin/console torq:generate-roles

echo Generating quantity values...
runuser -u www-data -- /var/www/html/bin/console definition:import:units config/quantityvalues.json --override
