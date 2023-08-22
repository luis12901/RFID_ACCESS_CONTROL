// Librerias

  #include <stdio.h>  /* printf, NULL */
  #include <stdlib.h> /* strtod */
  #include <esp_sleep.h>
  #include <SPI.h>
  #include <MFRC522.h>
  #include <LiquidCrystal_I2C.h>
  #include <ArduinoJson.h>
  #include <EEPROM.h>
  #include "esp_system.h"
  #include <Keypad.h>
  #include <WiFi.h>
  #include <HTTPClient.h>
  #include <WiFiClient.h>
  #include <ESPmDNS.h>


// prototypeFunctions();   // USe it only if the code doesn't compile for some missing prototype functions

void setup() {
  pinConfig();
  interfaceInit();
  beginNetworking();
}

void loop() {

    if(onlineVerification()){
        validateCardPresence();
    }
    else{

    }
  
}




