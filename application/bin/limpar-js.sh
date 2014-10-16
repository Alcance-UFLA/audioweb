#!/bin/bash

CURDIR=$(dirname $(realpath "$0"))
HTDOCS=$(realpath "${CURDIR}/../../htdocs")

echo "Limpando arquivos JS"
for i in $(find "${HTDOCS}/" -name "*.min.js" | grep -v "tb.min.js" | grep -v "respond.min.js" | grep -v "html5shiv.min.js")
do
    if [ -f "$i" ]
    then
        echo "Limpando: $i"
        rm "$i"
    fi
done
echo "OK"
