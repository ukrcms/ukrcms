#!/bin/bash

source `dirname $BASH_SOURCE`/../dev-data/lib.sh

# check for syntax

#./check-php-syntax.sh  "`pwd`/.."

echo $LIB_BEHAT_PATH ;

#--tags "@Ub\Helper\Arrays"

$LIB_BEHAT_PATH --config=main-behat.yml $@
