#!/bin/bash

source `dirname $BASH_SOURCE`/../dev-data/lib.sh

# check for syntax

#./check-php-syntax.sh  "`pwd`/.."

#--tags "@Ub\Helper\Arrays"

$LIB_BEHAT_PATH --config=main-behat.yml $@
