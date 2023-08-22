
// Peripheral_pins

  #define SS_PIN 5
  #define RST_PIN 35
  #define BUZZER_PIN 12
  #define LOCK_PIN 32
  #define LCD 25
  #define RFID 26
  #define deepSleepPin 27
  #define esp32ResetPin 


// RFID CARD
  MFRC522 mfrc522(SS_PIN, RST_PIN);
  int readData[4];
  String serialNumber = "";


// Database
  String json1 = "{\"serialNumber\":\"";
  String json2 = "\"}";
  String jsonMessage;

