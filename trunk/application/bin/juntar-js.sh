#!/bin/bash

echo "Compactando arquivos JS"
java -jar ./yuicompressor.jar --type js -v ../../htdocs/js/audioimagem.js -o ../../htdocs/js/audioimagem.min.js
echo "OK"

echo "Juntando arquivos JS"
cat ../../htdocs/js/jquery.min.js ../../htdocs/js/bootstrap.min.js ../../htdocs/js/audioimagem.min.js > ../../htdocs/js/tb.js
echo "OK"
