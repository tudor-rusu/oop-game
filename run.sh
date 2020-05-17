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

# Docker run
docker-compose -f .docker/deploy/docker-compose.yml up -d

# register SSL certificate if is set HTTPS Protocol
if [ $httpProtocol == 'https' ]
then
  echo "${BLU}Register self-signed SSL Certificate in your system${RST}"
  ex +'/BEGIN CERTIFICATE/,/END CERTIFICATE/p' <(echo QUIT | openssl s_client -showcerts -connect $PROJECT_URL:443) -scq > /tmp/$PROJECT_URL.pem
  openssl x509 -outform der -in /tmp/$PROJECT_URL.pem -out /tmp/$PROJECT_URL.der
  if ! [ -x "$(command -v certutil)" ]
  then
    echo "${BLU}Install ${BLD}certutil${RST} ${BLU}in your system${RST}"
    sudo apt install libnss3-tools
  fi
  certutil -d sql:$HOME/.pki/nssdb -A -n "$PROJECT_URL Certification Authority" -i /tmp/$PROJECT_URL.der -t TCP,TCP,TCP
  rm /tmp/$PROJECT_URL* # remove all temporary files
fi

# show the final result
listString=("$projectUrl")
drawResult "${listString}"
echo "${RST}"