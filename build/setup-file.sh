#/bin/bash

tempdir=$2

filename="$1.ino"
filepath="sketches/$1/$filename"
temppath="$tempdir/$filename"

version=$(cat /tmp/version)
echo "Old version: $version"
((version++))
echo "New version: $version"

echo "Generating $tempdir"
mkdir -p $tempdir && \
\
echo "Configuring $filepath with new version on $temppath" && \
sed -e "s/__CODEBENDER_AUTO_VERSION__/$version/g" -e "s/__CODEBENDER_UPDATE_URL__/http:\/\/che-test-tzikis1.c9users.io\/test.php/g" $filepath > $temppath && \
echo "New file at $temppath"
