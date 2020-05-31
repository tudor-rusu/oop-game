#!/usr/bin/env bash
# Functions repository
set -e

# global vars
RED=$(tput setaf 1)
GRN=$(tput setaf 2)
BLU=$(tput setaf 4)
BLD=$(tput bold)
REV=$(tput rev)
RST=$(tput sgr0) # reset colors

# functions
function replaceFileRow() {
  file=$1
  search=$2
  replace=$3

  while IFS=$'\n' read -r p || [[ -n "$p" ]]
  do
    if [[ ${p} == *${search}* ]]; then
      sed -i "s#$p#$replace#g" "$file"
    fi
  done < "$file"
}

function replaceAllInFile() {
  file=$1
  search=$2
  replace=$3

  sed -i "s#$search#$replace#g" "$file"
}

function longestStringInList() {
    listString=$1
    longestValue=-1
    for string in "${listString[@]}"
    do
        if [[ ${#string} -gt ${longestValue} ]]
        then
            longestValue=${#string}
        fi
    done
    echo ${longestValue}
}

function drawResult() {
    listString=$1
    maxString=$(longestStringInList "${listString}")
    sPre=6
    interiorWidth=$(( $maxString + sPre * 2 ))

    printf "${GRN}\u2554$(printf '\u2550%0.s' $(seq ${interiorWidth}))\u2557\n${RST}"
    printf "${GRN}\u2551${RST}%${interiorWidth}s${GRN}\u2551\n${RST}" "$(printf \\$(printf '%03o' 32))"

    for string in "${listString[@]}"
    do
        sApp=$(( $interiorWidth - $sPre - ${#string} ))
        printf "${GRN}\u2551${RST}%${sPre}s%s%${sApp}s${GRN}\u2551\n${RST}" "$(printf \\$(printf '%03o' 32))" "$string" "$(printf \\$(printf '%03o' 32))"
    done

    printf "${GRN}\u2551${RST}%${interiorWidth}s${GRN}\u2551\n${RST}" "$(printf \\$(printf '%03o' 32))"
    printf "${GRN}\u255A$(printf '\u2550%0.s' $(seq ${interiorWidth}))\u255D\n${RST}"
}

function checkLocalOs() {
    if [[ "$OSTYPE" == "linux-gnu"* ]]; then
        systemType="Linux"
    elif [[ "$OSTYPE" == "darwin"* ]]; then
        systemType="Mac OSX"
    elif [[ "$OSTYPE" == "cygwin" ]]; then
        systemType="Cygwin"
    elif [[ "$OSTYPE" == "msys" ]]; then
        systemType="Windows"
    elif [[ "$OSTYPE" == "win32" ]]; then
        systemType="Windows"
    elif [[ "$OSTYPE" == "freebsd"* ]]; then
        systemType="Freebsd"
    else
        systemType="Unknown"
    fi
    echo ${systemType}
}

# If running on bash for Windows, any argument starting with a forward slash is automatically
# interpreted as a drive path. To stop that, you can prefix with 2 forward slashes instead
# of 1 - but in the specific case of openssl, that causes the first CN segment key to be read as
# "/O" instead of "O", and is skipped. We work around that by prefixing with a spurious segment,
# which will be skipped by openssl
function fixupCnSubject() {
    local result="${1}"
    case $OSTYPE in
        msys|win32) result="//XX=x${result}"
    esac
    echo "$result"
}