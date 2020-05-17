#!/usr/bin/env bash
# Main script
set -e

# include global vars and functions repository
source .docker/functions.sh

####################### 1. set the config
source .docker/config.sh
####################### 2. build and deploy nginx
source .docker/build/nginx/nginx.sh
####################### 3. build and deploy php
source .docker/build/php/php.sh

# Show the final result
listString=("$projectUrl")
drawResult "${listString}"
echo "${RST}"