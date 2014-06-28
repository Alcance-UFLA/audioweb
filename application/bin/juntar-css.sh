#!/bin/bash

echo "Compactando arquivos CSS"
java -jar ./yuicompressor.jar --type css -v ../../htdocs/css/bootstrap.css -o ../../htdocs/css/bootstrap.min.css
java -jar ./yuicompressor.jar --type css -v ../../htdocs/css/bootstrap-theme.css -o ../../htdocs/css/bootstrap-theme.min.css
echo "OK"

echo "Juntando arquivos CSS"
cat ../../htdocs/css/bootstrap.min.css ../../htdocs/css/bootstrap-theme.min.css > ../../htdocs/css/tb.css
echo "OK"