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
LOCAL_DIR="../todoconta-pro/"

# Conexión y sincronización de archivos (subir solo el contenido necesario)
lftp -e "
open -u $USER,$PASSWORD $HOST;
mirror --reverse --delete --verbose \
$LOCAL_DIR $REMOTE_DIR;
bye
"