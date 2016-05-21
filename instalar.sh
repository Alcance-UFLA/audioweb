#!/bin/bash
PHPEXEC=$(type -P php)
CURLEXEC=$(type -P curl)
if [ ! -f "$PHPEXEC" ]
then
	echo "O php-cli nao foi encontrado"
	exit 1
fi
if [ ! -f "$CURLEXEC" ]
then
	echo "O comando curl nao foi encontrado"
	exit 1
fi

if [ ! -f "composer.phar" ]
then
	echo "INSTALANDO O COMPOSER"
	"$CURLEXEC" -sS "https://getcomposer.org/installer" | "$PHPEXEC"
else
	"$PHPEXEC" "composer.phar" "self-update"
fi

echo "INSTALANDO O AUDIOWEB PELO COMPOSER"
"$PHPEXEC" "composer.phar" install

if (( $? == 0 ))
then
	echo "FIM DA INSTALACAO COM SUCESSO"
else
	echo "ERRO DURANTE A INSTALACAO"
	exit 1
fi

