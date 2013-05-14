#!/bin/bash



read -d '' HELP <<EOF
    generate.sh -h
    -h             - show this help

    generate.sh /path/to/sami.php
    Path to sami generator

EOF

  SCRIPT_DIR=$(dirname $(readlink -f $BASH_SOURCE))
  SAMI_SCRIPT="$SCRIPT_DIR/../../../composer/vendor/sami/sami/sami.php"
  SAMI_CACHE_DIR="/tmp/sami-cache"


  if [ "$1" == "-h" ]; then
    echo "$HELP";
   exit;
  fi

  if [ "$1" != "" ]; then
  echo "$HELP";
    SAMI_SCRIPT=$1
   exit;
  fi

 $SAMI_SCRIPT update --force "$SCRIPT_DIR/config.php" -v
 rm -rf $SAMI_CACHE_DIR
