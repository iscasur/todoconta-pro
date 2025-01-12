#!/bin/bash

# Cargar variables desde el archivo .env
if [ -f .env ]; then
  export $(grep -v '^#' .env | xargs)
else
  echo "Archivo .env no encontrado. Por favor, créalo antes de ejecutar el script."
  exit 1
fi

# Configuración FTP
HOST=$FTP_HOST
USER=$FTP_USER
PASSWORD=$FTP_PASSWORD
REMOTE_DIR=$REMOTE_DIR
LOCAL_DIR="./"

# Conexión y sincronización de archivos (excluyendo lo innecesario)
lftp -e "
open -u $USER,$PASSWORD $HOST;
mirror --reverse --delete --verbose \
--exclude \".DS_Store\" \
--exclude \"node_modules/\" \
--exclude \"vendor/\" \
--exclude \"composer.json\" \
--exclude \"composer.lock\" \
--exclude \"package-lock.json\" \
--exclude \"package.json\" \
--exclude \"yarn.lock\" \
--exclude \".git/\" \
--exclude \".gitignore\" \
--exclude \"README.md\" \
--exclude \"sass/\" \
--exclude \".stylelintrc.json\" \
--exclude \".eslintrc\" \
--exclude \".travis.yml\" \
--exclude \"phpcs.xml.dist\" \
--exclude \"style.css.map\" \
--exclude \"./assets/css/component-styles.css\" \
--exclude \"deploy.sh\" \
$LOCAL_DIR $REMOTE_DIR;
bye
"