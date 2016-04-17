#/bin/bash

cd build &&\
mkdir -p /tmp/cbtest &&\
./arduino-builder-linux -compile -logger=machine -hardware ./hardware-linux -tools ./tools-builder-linux -tools ./hardware-linux/tools/avr -built-in-libraries ./libraries-linux -fqbn=esp8266com:esp8266:huzzah:CpuFrequency=80,UploadSpeed=115200,FlashSize=4M3M -ide-version=10608 -build-path "/tmp/cbtest" -warnings=none -prefs=build.warn_data_percentage=75 -verbose ../sketches/Blink/Blink.ino &&\
cp /tmp/cbtest/Blink.ino.bin ./binaries/