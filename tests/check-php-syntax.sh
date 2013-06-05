#!/bin/bash

  script_dir (){
    echo "`dirname $(script_file)`"
  }
  script_file (){
   echo "`pwd`/$0" | sed 's#/./#/#g'
  }



  if [ ! -z $1 ] && [ -d $1 ] ; then
   PROJECT_DIR="$1"
   echo "Find files: $1";
   LIST=$(find $1 -type f -regex ".*.\(php\|html\)")
  else
    echo "Find files from git "
    PROJECT_DIR="$(script_dir)/.."
    LIST=$(cd $PROJECT_DIR && git ls-files --other --modified --exclude-standard --full-name | grep ".*\.php\|.*\.html$");
  fi
  echo ""
  ERRORS_BUFFER=""
  for file in $LIST
    do

      ERRORS=$(php -l $file 2>&1 | grep "Parse error")
      if [ "$ERRORS" != "" ]; then
          ERRORS_BUFFER="$ERRORS_BUFFER\n$ERRORS"
          echo "ERROR:$file "
      fi
  done

  if [ "$ERRORS_BUFFER" != "" ]; then
      echo
      echo
      echo "These errors were found: "
      echo "$ERRORS_BUFFER"
      echo

      exit 1
  else
      echo "No errors."
  fi
