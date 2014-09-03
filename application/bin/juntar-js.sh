#!/bin/bash

CURDIR=$(dirname $(realpath "$0"))
HTDOCS=$(realpath "${CURDIR}/../../htdocs")

echo "Juntando arquivos JS"
cat "${HTDOCS}/js/jquery.js" "${HTDOCS}/js/bootstrap.js" "${HTDOCS}/js/audioweb.js" > "${HTDOCS}/js/tb.js"

echo "Compactando arquivos JS"
for ARQ in $(find "$HTDOCS" -name "*.js")
do
    ARQMIN="${ARQ%%.*}.min.js"
    EXTENSAO="${ARQ#*.}"
    if [ $EXTENSAO = "js" ]
    then
        echo "Compactando: $ARQ"
        java -jar "${CURDIR}/yuicompressor.jar" --type js --charset "UTF-8" "$ARQ" -o "$ARQMIN"
    fi
done

echo "OK"
