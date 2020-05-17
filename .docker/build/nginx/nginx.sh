#!/usr/bin/env bash
# build and deploy nginx
set -e

# include global vars and functions repository
source .docker/functions.sh
source .env # get configuration file
projectUrl=""

# build and deploy nginx
echo "${BLU}Build the ${BLD}nginx${RST} ${BLU}container${RST}"
replaceAllInFile .docker/deploy/docker-compose.yml project $PROJECT_NAME

httpProtocol='http'
# HTTP
nginxHttpHostPort=80
for port in $HTTP_PORTS_LIST
do
  if [ $(nc -z 127.0.0.1 $port && echo "USE" || echo "FREE") == 'FREE' ]
  then
    nginxHttpHostPort=$port
    break
  fi
done
replaceAllInFile .docker/deploy/docker-compose.yml "host80" "$nginxHttpHostPort:80"
echo "${GRN}HTTP settings have been made successfully.${RST}"

# HTTPS
while true; do
  read -rp "Do you want to implement HTTPS access? ${RED}[y/N]${RST}: " yn
  case $yn in
      [Yy]* )
        httpProtocol='https'
        nginxHttpsHostPort=463
        for port in $HTTPS_PORTS_LIST
        do
          if [ $(nc -z 127.0.0.1 $port && echo "USE" || echo "FREE") == 'FREE' ]
          then
            nginxHttpsHostPort=$port
            break
          fi
        done
        replaceAllInFile .docker/deploy/docker-compose.yml "host443" "$nginxHttpsHostPort:443"
        replaceAllInFile .docker/deploy/docker-compose.yml nginxConf apps.conf
        projectUrl="Project URL: https://$PROJECT_URL"
        echo "${BLU}Generate self-signed SSL Certificate for 365days${RST}"
        replaceAllInFile .docker/deploy/docker-compose.yml localhost $PROJECT_URL
        openssl req -subj "/O=$PROJECT_NAME/CN=$PROJECT_URL" -addext "subjectAltName=DNS:$PROJECT_URL,DNS:www.$PROJECT_URL" -x509 -newkey rsa:4096 -nodes -keyout .docker/build/cert/$PROJECT_URL.key -out .docker/build/cert/$PROJECT_URL.pem -days 365
        echo "${GRN}HTTPS settings have been made successfully.${RST}"
        break;;
      [Nn]* )
        sed -i '/"host443"/d' .docker/deploy/docker-compose.yml
        sed -i '/localhost./d' .docker/deploy/docker-compose.yml
        replaceAllInFile .docker/deploy/docker-compose.yml nginxConf app.conf
        projectUrl="Project URL: http://$PROJECT_URL"
        if [ $nginxHttpHostPort -ne 80 ]
        then
            projectUrl+=":$nginxHttpHostPort"
        fi
        break;;
      * )
        sed -i '/"host443"/d' .docker/deploy/docker-compose.yml
        sed -i '/localhost./d' .docker/deploy/docker-compose.yml
        replaceAllInFile .docker/deploy/docker-compose.yml nginxConf app.conf
        projectUrl="Project URL: http://$PROJECT_URL"
        if [ $nginxHttpHostPort -ne 80 ]
        then
            projectUrl+=":$nginxHttpHostPort"
        fi
        break;;
  esac
done

# etc/hosts
if ! grep -Fxq "127.0.0.1 $PROJECT_URL" /etc/hosts
then
  while true; do
    read -rp "Do you want to add the project URL($PROJECT_URL) in etc/hosts? ${RED}[y/N]${RST}: " yn
    case $yn in
        [Yy]* )
          echo ${GRN}
          printf '\n%s\n%s' "# Project $PROJECT_NAME" "127.0.0.1 $PROJECT_URL" | sudo tee -a /etc/hosts
          echo ${RST}
          replaceAllInFile .docker/build/nginx/conf.d/app.conf localhost $PROJECT_URL
          if [ ${httpProtocol} == 'https' ]
          then
            replaceAllInFile .docker/build/nginx/conf.d/apps.conf localhost $PROJECT_URL
          fi
          echo "${GRN}Project URL($PROJECT_URL) have been add successfully.${RST}"
          break;;
        [Nn]* ) break;;
        * ) break;;
    esac
  done
fi
printf '\n%s\n' "${GRN}Nginx build and deploy have been made successfully.${RST}"