#!/bin/bash


 store() {
     export ${1}="${*:2}"
     [[ ${STORED} =~ "(^| )${1}($| )" ]] || STORED="${STORED} ${1}"
 }

 parse_config_variables () {
    while read line
    do
       data=$line
       data=`echo "$data" | grep "^define"`
       data=`echo "$data" | sed 's/\s*define(//g' `;
       data=`echo "$data" | sed 's/)\;$//g'`;

       name=`echo "$data" | sed 's#.\([^,]\+\).,\s*.*#\1#g'`
       value=`echo "$data" | sed 's#^.*,\s.\([^,]\+\).$#\1#g'`
       if [ ! -z $name ] ; then
        store $name "$value"
       fi
    done  < `dirname $BASH_SOURCE`/config.php
 }

 parse_config_variables

 # all constants from config.php available
 # echo "$TEST_INSTALLER_DIR";

