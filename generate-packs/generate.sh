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
  rm -rf $DIR/src/$name.zip
  cd "$SAVE_DIR" && zip -9 -r "$DIR/src/$name-1.0.zip" . && cd $DIR;

  rm -rf $SAVE_DIR;

  done;