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
if [[ ${httpProtocol} == 'https' ]]
then
  echo "${BLU}Register self-signed SSL Certificate in your system${RST}"
  if [[ ${localOs} == "Linux" ]]
  then
    ex +'/BEGIN CERTIFICATE/,/END CERTIFICATE/p' <(echo QUIT | openssl s_client -showcerts -connect $PROJECT_URL:443) -scq > /tmp/$PROJECT_URL.pem
    openssl x509 -outform der -in /tmp/$PROJECT_URL.pem -out /tmp/$PROJECT_URL.der
    if ! [[ -x "$(command -v certutil)" ]]
    then
      echo "${BLU}Install ${BLD}certutil${RST} ${BLU}in your system${RST}"
      sudo apt install libnss3-tools
    fi
    certutil -d sql:$HOME/.pki/nssdb -A -n "$PROJECT_URL Certification Authority" -i /tmp/$PROJECT_URL.der -t TCP,TCP,TCP
    rm /tmp/$PROJECT_URL* # remove all temporary files
  elif [[ ${localOs} == "Windows" ]]
  then
    cp ./.docker/build/cert/$PROJECT_URL.pem ./.docker/build/cert/$PROJECT_URL.crt
    echo "1. Right-click 'Start' and select 'Run'"
    echo "2. Type in 'mmc' and click 'OK'"
    echo "3. On the 'User Account Control' screen click 'Yes'"
    echo "4. Once 'Microsoft Management Console' opens click 'File' and select 'Add/Remove Snap-in'"
    echo "5. In the left menu select 'Certificates' and click 'Add'"
    echo "6. On the next screen click the radio button next to 'Computer account' and click 'Next'"
    echo "7. Click 'Finish'"
    echo "8. Once you are returned to the 'Add or Remove Snap-ins' screen click 'OK'"
    echo "9. In the Microsoft Management Console' window click on 'Certificates (Local Computer)'"
    echo "10. Right-click on 'Trusted Root Certificate Authorities' in the left pane and select 'All Tasks' and then 'Import'"
    echo "11. Click 'Next' in the 'Certificate Import Wizard'"
    echo "12. Browse to LOCAL-PROJECT-ROOT/.docker/build/cert/$PROJECT_URL.crt and select it. Then click 'Open'"
    echo "13. On the Certificate Store window ensure that it says 'Trusted Root Certificate Authorities' and click 'Next'"
    echo "14. Click 'Finish' and then 'OK'"
    echo "15. Close and restart the browser and you should have the https://$PROJECT_URL secure site"
  else
    echo "Search and use the steps for register self-signed SSL Certificate specific for your system"
  fi
  printf '%s\n' "${GRN}Self-signed SSL Certificate have been register successfully in your system.${RST}"
fi

# show the final result
listString=("$projectUrl")
drawResult "${listString}"
echo "${RST}"