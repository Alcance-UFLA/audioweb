#!/bin/bash
PHPEXEC=$(type -P php)
if [ ! -f "$PHPEXEC" ]
then
    echo "O php-cli nao foi encontrado"
    exit 1
fi

if [ ! -f "composer.phar" ]
then
    echo "INSTALANDO O COMPOSER"
    curl -sS https://getcomposer.org/installer | php
fi

echo "INSTALANDO O AUDIOWEB PELO COMPOSER"
php "composer.phar" install

if (( $? == 0 ))
then
    echo "FIM DA INSTALACAO COM SUCESSO"
else
    echo "ERRO DURANTE A INSTALACAO"
    exit 1
fi