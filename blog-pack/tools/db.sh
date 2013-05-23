#!/bin/bash


read -d '' HELP <<EOF
  ./db.sh uc -r
  -r             - restore
  -b             - backup
  uc             - db name

EOF



  if [ "$1" == "" ]
   then
    echo "$HELP";
   exit;
  fi

  SCRIPT_DIR=$(dirname $(readlink -f $BASH_SOURCE))

  FILE_NAME="$SCRIPT_DIR/../install/$1.sql"
  DB_NAME="$1"
  DB_USER="root"
  DB_PASS="1111"


  if [ "$2" == "-b" ]
  then
    echo "backup ";
    mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $FILE_NAME --add-drop-table --comments=false ;

    sed ':a;N;$!ba;s/\n/THISISUNIQUESTRING/g' -i $FILE_NAME;
    sed -e 's/;THISISUNIQUESTRING/;\n/g' -i $FILE_NAME;
    sed -e 's/THISISUNIQUESTRING//g' -i $FILE_NAME;

  elif [ "$2" == "-r" ]
  then
    echo "restore"
    mysql -u $DB_USER -p$DB_PASS $DB_NAME < $FILE_NAME;
  else
    echo "$HELP"
  fi
