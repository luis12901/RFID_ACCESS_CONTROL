



void pinConfig(){

  pinMode(deepSleepPin, INPUT_PULLDOWN);
  pinMode(LCD, OUTPUT);
  pinMode(RFID, OUTPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(LOCK_PIN, OUTPUT);

  digitalWrite(LCD, LOW);
  digitalWrite(RFID, LOW);
  digitalWrite(BUZZER_PIN, LOW);
  digitalWrite(LOCK_PIN, HIGH);


  //attachInterrupt(digitalPinToInterrupt(deepSleepPin), boton_1_isr, RISING);          // Deepsleep Mode Pin || GND Permanently


}