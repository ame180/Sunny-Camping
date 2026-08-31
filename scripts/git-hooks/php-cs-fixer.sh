#!/bin/bash

RED="\033[41m"
GREEN="\033[42m"
NC="\033[49m"

composer check-platform-reqs --no-interaction > /dev/null 2>&1
PLATFORM_STATUS=$?

if [ $PLATFORM_STATUS -ne 0 ]; then
  echo -e "${RED}--> The PHP version in use does not satisfy the project requirements${NC}"
  exit 1
fi

echo "--> Running PHP CS Fixer to check for code style issues..."
php bin/php-cs-fixer fix --dry-run > /dev/null 2>&1
FIX_STATUS=$?

if [ $FIX_STATUS -ne 0 ]; then
  echo -e "${RED}--> PHP CS Fixer found problems, applying fixes automatically${NC}"
  php bin/php-cs-fixer fix
  exit 1
fi

echo -e "${GREEN}--> PHP CS Fixer found no problems${NC}"
exit 0
