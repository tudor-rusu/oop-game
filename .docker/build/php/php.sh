#!/usr/bin/env bash
# build and deploy php
set -e

# include global vars and functions repository
source .docker/functions.sh
source .env # get configuration file
phpVersion=$PHP_VERSION

# build and deploy php
echo "${BLU}Build the ${BLD}php${RST} ${BLU}container${RST}"
replaceAllInFile .docker/deploy/docker-compose.yml project $PROJECT_NAME
replaceAllInFile .docker/build/php/Dockerfile php-version $phpVersion
replaceAllInFile .docker/build/php/Dockerfile app-gid $APP_GID
replaceAllInFile .docker/build/php/Dockerfile app-uid $APP_UID
replaceAllInFile .docker/build/php/local.ini UPLOAD_MAX_FILESIZE $UPLOAD_MAX_FILESIZE
replaceAllInFile .docker/build/php/local.ini POST_MAX_SIZE $POST_MAX_SIZE
replaceAllInFile .docker/build/php/local.ini PHP_MEMORY_LIMIT $PHP_MEMORY_LIMIT
replaceAllInFile .docker/build/php/local.ini PHP_TIMEZONE $PHP_TIMEZONE
replaceAllInFile .docker/build/nginx/conf.d/app.conf php_container_name "$PROJECT_NAME-app"
replaceAllInFile .docker/build/nginx/conf.d/apps.conf php_container_name "$PROJECT_NAME-app"

while true; do
    read -rp "Actual project PHP version is ${REV}$phpVersion${RST}, do you want to change it? ${RED}[y/N]${RST}: " yn
    case $yn in
        [Yy]* )
          read -rp "Enter PHP version: " newPhpVersion;
          replaceFileRow ./docker.conf "PHP_VERSION" "PHP_VERSION='$newPhpVersion'";
          replaceAllInFile .docker/build/php/Dockerfile php-version $newPhpVersion
          phpVersion=$newPhpVersion
          break;;
        [Nn]* ) break;;
        * ) break;;
    esac
done

printf '\n%s\n' "${GRN}PHP build and deploy have been made successfully.${RST}"