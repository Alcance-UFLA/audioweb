#!/bin/bash

CURDIR=$(dirname $(realpath "$0"))
APPDIR=$(realpath "${CURDIR}/..")

echo "GERANDO ARQUIVO COM STRING ALEATORIA"

if [ ! -f "${APPDIR}/segredo.php" ]
then
    php -r "echo '<?php return \'' . md5(microtime(true)) . '\';';" > "${APPDIR}/segredo.php"
fi

echo "OK"