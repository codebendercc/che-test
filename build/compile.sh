#/bin/bash

randfolder=$RANDOM
tempdir="/tmp/$randfolder"

./build/setup-file.sh $1 $tempdir &&\

cd build &&\
mkdir -p /tmp/cbtest &&\
./arduino-builder-linux -compile -logger=machine -hardware ./hardware-linux -tools ./tools-builder-linux -tools ./hardware-linux/tools/avr -built-in-libraries ./libraries-linux -fqbn=esp8266com:esp8266:huzzah:CpuFrequency=80,UploadSpeed=115200,FlashSize=4M3M -ide-version=10608 -build-path "/tmp/cbtest" -warnings=none -prefs=build.warn_data_percentage=75 -verbose $tempdir/$1.ino &&\
./bump-version.sh && \
version=$(cat /tmp/version) && \
cp /tmp/cbtest/$1.ino.bin ../binaries/$1.ino.bin.v$version &&\
echo -e "\n\nSuccessfuly built $1. New version: $version"
