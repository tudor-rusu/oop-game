#!/usr/bin/env bash
# build and deploy php
set -e

# include global vars and functions repository
source .docker/functions.sh
source .env # get configuration file
phpVersion=$PHP_VERSION
