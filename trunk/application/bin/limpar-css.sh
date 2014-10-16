#!/bin/bash

CURDIR=$(dirname $(realpath "$0"))
HTDOCS=$(realpath "${CURDIR}/../../htdocs")

echo "Limpando arquivos CSS"
for i in $(find "${HTDOCS}/" -name "*.min.css" | grep -v "tb.min.css")
do
    if [ -f "$i" ]
    then
        echo "Limpando: $i"
        rm "$i"
    fi
done
echo "OK"
