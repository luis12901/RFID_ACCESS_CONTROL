

bool beginNetworking(){

  if(WifiConnected()){

      if(ServerConnected()){
        
        digitalWrite(BUZZER_PIN, HIGH);
        delay(300);
        digitalWrite(BUZZER_PIN, LOW);
        delay(200);
        digitalWrite(BUZZER_PIN, HIGH);
        delay(300);
        digitalWrite(BUZZER_PIN, LOW);
        Serial.print("Connected");
        
        return true;

      }
      else{
        
        digitalWrite(BUZZER_PIN, HIGH);
        delay(1500);
        digitalWrite(BUZZER_PIN, LOW);
        Serial.print("Connection Error");

        return false;

      }

  }
  else{
    
    digitalWrite(BUZZER_PIN, HIGH);
    delay(1500);
    digitalWrite(BUZZER_PIN, LOW);
    Serial.print("Connection Error");

    return false;

  }

}