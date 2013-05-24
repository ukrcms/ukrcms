#!/bin/bash


 # copy bundles
 SCRIPT_DIR=$(dirname $(readlink -f $BASH_SOURCE))
 DIR=$SCRIPT_DIR;

 INSTALL_DIR="/home/ivan/work/www/test-uk4455"
 rm -rf $INSTALL_DIR;
 mkdir -p $INSTALL_DIR;

 PACKS_DIR="$DIR/../../generate-packs/src"
 for file in `ls $PACKS_DIR`
  do
  PACK="$PACKS_DIR/$file";
  unzip $PACK -d $INSTALL_DIR
  chmod 0777 "$INSTALL_DIR/protected/config/main.php"
  done;