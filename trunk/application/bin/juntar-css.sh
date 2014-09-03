#!/bin/bash

CURDIR=$(dirname $(realpath "$0"))
HTDOCS=$(realpath "${CURDIR}/../../htdocs")

echo "Juntando arquivos CSS"
cat "${HTDOCS}/css/bootstrap.css" "${HTDOCS}/css/bootstrap-theme.css" "${HTDOCS}/css/audioweb.css"  > "${HTDOCS}/css/tb.css"

echo "Compactando arquivos CSS"
for ARQ in $(find "$HTDOCS" -name "*.css")
do
    ARQMIN="${ARQ%%.*}.min.css"
    EXTENSAO="${ARQ#*.}"
    if [ $EXTENSAO = "css" ]
    then
        echo "Compactando: $ARQ"
        java -jar "${CURDIR}/yuicompressor.jar" --type css --charset "UTF-8" "$ARQ" -o "$ARQMIN"
    fi
done

echo "OK"