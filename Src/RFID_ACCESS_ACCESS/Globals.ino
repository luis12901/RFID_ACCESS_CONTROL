/*
   Project: RFID Access Control ()
   Description: 
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/

// Peripheral_pins

  #define SS_PIN 5
  #define RST_PIN 35
  #define BUZZER_PIN 2
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


  String currentLine = "";  
  long int tiempoConexionInicio = 0;
  bool finMensaje = false; 
  long int tiempoComparacion = 0;


  uint8_t acceso_nivel = 0;
  uint8_t acceso = 0;
  uint8_t estado = 0;
  String claveS;
  String nombreS;


  WiFiClient clienteServidor;

  


// LCD Variables
    int nombreLength = 0;
    int espaciosLibres = 0;
    int espaciosIzquierda = 0;

// Offline Mode
  //bool key_pressed = false;
  volatile bool boton_1 = false;

// Keyboard
  const uint8_t ROWS = 4;
  const uint8_t COLS = 4;

  char keys[ROWS][COLS] = {
    { '1', '2', '3', 'A' },
    { '4', '5', '6', 'B' },
    { '7', '8', '9', 'C' },
    { '*', '0', '#', 'D' }
  };

  uint8_t colPins[COLS] = { 16, 4, 2, 15 };
  uint8_t rowPins[ROWS] = { 19, 18, 5, 17 };

  Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);

  char key;
