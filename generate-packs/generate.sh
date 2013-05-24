#!/bin/bash


 # copy bundles
 SCRIPT_DIR=$(dirname $(readlink -f $BASH_SOURCE))
 DIR=$SCRIPT_DIR;

 for path in `find $DIR/../ -maxdepth 1 -name *-pack  -type d `
 do
  name=`basename $path`

  echo "*** Generate -- $name";

  SAVE_DIR="$DIR/src/$name"
  rm -rf $SAVE_DIR;
  mkdir -p $SAVE_DIR




   UC_DIR="$DIR/../core/*";

   echo "Copy core FILES";
   CORE_DIR="$SAVE_DIR/ukrcms/core/";


   mkdir -p $CORE_DIR;
   cp -R $UC_DIR $CORE_DIR;

   echo "deny from all" > "$SAVE_DIR/ukrcms/.htaccess"


   folders=("files" "protected" "themes" "install")
   for item in ${folders[*]}
   do
     U_DIR="$path/$item";
     echo "++ copy dir :: $item";
     cp -R $U_DIR $SAVE_DIR;
   done

   echo "";
   echo "Copy bundles dir";

   BUNDLES_DIR="$SAVE_DIR/ukrcms/bundles";

   bundles=("Admin" "Site" "Helper" "Simpleblog" "Users")
   mkdir -p $BUNDLES_DIR;

   for bundle in ${bundles[*]}
   do
     UB_DIR="$DIR/../bundles/$bundle";
     echo ".Copy bundle :: $bundle";

     cp -r $UB_DIR "$SAVE_DIR/ukrcms/bundles";
   done


  files=("index.php" ".htaccess")
  for file in ${files[*]}
  do
    cp -r "$path/$file" "$SAVE_DIR/$file";
  done

  find "$SAVE_DIR/index.php" -type f -exec sed -i -e 's/\/..\/core/\/ukrcms\/core/g' {} \;
  find "$SAVE_DIR/index.php" -type f -exec sed -i -e 's/\/..\/bundles/\/ukrcms\/bundles/g' {} \;

  CONFIG_FILE="$SAVE_DIR/protected/config/main.php"


  replaceInConfig=(
    's/mysql:host=localhost;dbname=uc/mysql:host=INSTALL_DB_ADDRESS;dbname=INSTALL_DB_NAME/g'
    's/\/admin-panel\//\/INSTALL_ADMIN_PATH\//g'
    's/\/ukrcms\/[a-z]*-pack/INSTALL_SITE_PATH/g'
    "s/'username'\s*=>\s*'root',/'username'=>'INSTALL_DB_USER',/g"
    "s/'password'\s*=>\s*'1111',/'password'=>'INSTALL_DB_PASS',/g"
    "s/'tablePrefix'\s*=>\s*'uc_',/'tablePrefix'=>'INSTALL_DB_PREFIX',/g"
  )
  for regexp in ${replaceInConfig[*]}
  do
    sed -e $regexp -i $CONFIG_FILE;
  done;


  ZIP_FILE="$DIR/src/$name-1.0.zip"

  rm -rf $ZIP_FILE
  cd "$SAVE_DIR" && zip -9 -r $ZIP_FILE . && cd $DIR;
  rm -rf $SAVE_DIR;

  done;