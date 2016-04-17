/**
   httpUpdate.ino

    Created on: 27.11.2015

*/

#include <Arduino.h>

#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>

#include <ESP8266HTTPClient.h>
#include <ESP8266httpUpdate.h>

#define USE_SERIAL Serial

ESP8266WiFiMulti WiFiMulti;

void setup() {

  USE_SERIAL.begin(115200);
  // USE_SERIAL.setDebugOutput(true);

  USE_SERIAL.println();
  USE_SERIAL.println();
  USE_SERIAL.println();

  for (uint8_t t = 4; t > 0; t--) {
    USE_SERIAL.printf("[SETUP] WAIT %d...\n", t);
    USE_SERIAL.flush();
    delay(1000);
  }

  WiFiMulti.addAP("LookyHome2.4", "Looky1987");

  pinMode(0, OUTPUT);
}

void tryToUpdate(void);

void loop() {

  static unsigned long blinkTimestamp = 0;
  static const int interval = 1000;
  if (millis() - blinkTimestamp > interval)
  {
    static bool status = 0;
    digitalWrite(0, status);
    if (status == 0) status = 1;
    else status = 0;

    blinkTimestamp = millis();
  }
  tryToUpdate();
}

void tryToUpdate(void)
{
  static unsigned long timestamp = 0;
  static const int interval = 10000;
  if (millis() > 30000 && millis() - timestamp > interval)
  {
    timestamp = millis();
    
    // wait for WiFi connection
    if ((WiFiMulti.run() == WL_CONNECTED)) {

      Serial.println("Trying to fetch new binary");

      t_httpUpdate_return ret = ESPhttpUpdate.update("http://che-test-tzikis1.c9users.io/test.php", __TIMESTAMP__);
      //t_httpUpdate_return  ret = ESPhttpUpdate.update("https://server/file.bin");

      switch (ret) {
        case HTTP_UPDATE_FAILED:
          USE_SERIAL.printf("HTTP_UPDATE_FAILD Error (%d): %s", ESPhttpUpdate.getLastError(), ESPhttpUpdate.getLastErrorString().c_str());
          break;

        case HTTP_UPDATE_NO_UPDATES:
          USE_SERIAL.println("HTTP_UPDATE_NO_UPDATES");
          break;

        case HTTP_UPDATE_OK:
          USE_SERIAL.println("HTTP_UPDATE_OK");
          break;
      }
    }
  }
}
