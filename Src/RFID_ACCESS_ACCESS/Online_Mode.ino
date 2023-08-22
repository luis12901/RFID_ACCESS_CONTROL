
bool onlineVerification(){

  
  if(WifiConnected()){

      if(ServerConnected()){
   
        Serial.print("Connected Successfully");
        return true;

      }
      else{

        Serial.print("Connection Error (Code: 002)");
        return false;

      }

  }
  else{

    Serial.print("Connection Error (Code: 001)");
    return false;

  }

}


void getRFIDData(){

  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {


      Serial.println("Card Detected!");
      Serial.println("Please Wait .........");

      
      for (int i = 0; i < 4; i++) {

        readData[i] = mfrc522.uid.uidByte[i];

      }

      
      for (int i = 0; i < 4; i++) {

        String decimalByte = String(readData[i]);
        serialNumber += decimalByte;

      }

  }

}


void validateCardPresence(){
   

  if (serialNumber.length() > 0) {

    Serial.println("RFID CARD: " + serialNumber);

    postJSONToServer();
    
  }


}

void conexionURL(int counter, char* mensajeJSON, char* servidor, bool pruebas) {
  char temporal[50];
  char mensajeHTML[400];
  char Usuario[10] = "bot33";
  char urlVar[10] = "/";
  int j = 0;

  memset(mensajeHTML, NULL, sizeof(mensajeHTML));
  memset(temporal, NULL, sizeof(temporal));


  int cuantosBytes = strlen(mensajeJSON);
  sprintf(temporal, "POST %s HTTP/1.0\r\n", urlVar);
  strcat(mensajeHTML, temporal);

  sprintf(temporal, "Host: %s \r\n", servidor);
  strcat(mensajeHTML, temporal);

  sprintf(temporal, "User-Agent: %s \r\n", Usuario);
  strcat(mensajeHTML, temporal);

  sprintf(temporal, "Content-Length: %i \r\n", cuantosBytes);
  strcat(mensajeHTML, temporal);

  strcat(mensajeHTML, "Content-Type: application/json\r\n");
  strcat(mensajeHTML, "\r\n");
  strcat(mensajeHTML, mensajeJSON);



  int cuantosMensaje = strlen(mensajeHTML);
  if (pruebas == false) {
    WiFiClient client;
    HTTPClient http;
    http.begin(client, servidor);
    http.addHeader("Content-Type", "application/json");
    int httpResponseCode = http.POST(mensajeJSON);
    Serial.print("Codigo HTTP de respuesta: ");
    Serial.println(httpResponseCode);
    http.end();


  } else {
    Serial.println("Bytes para transmitir: ");
    Serial.println("");
    Serial.println(cuantosMensaje);
    for (j = 0; j <= cuantosMensaje - 1; j++) {
      Serial.print(mensajeHTML[j]);
    }
    Serial.println(" ");
  }
}

void postJSONToServer(){
      uint8_t counter = 0; 
      jsonMessage = json1 + serialNumber + json2;
      char completedJsonMessage[150];
      jsonMessage.toCharArray(completedJsonMessage, 150);
      conexionURL(counter, completedJsonMessage, "http://192.168.43.122/registro_y_consulta.php", false);

}


void getJSONFromServer(){


    WiFiClient clienteServidor = servidor.available();
    finMensaje = false;

    if (clienteServidor) {

        tiempoConexionInicio = xTaskGetTickCount();

        while (clienteServidor.connected()) {

            if (clienteServidor.available() > 0) {

                char c = clienteServidor.read();
              
                if (c == '}') {

                    finMensaje = true;

                }
                if (c == '\n') {

                    if (currentLine.length() == 0) {

                        //Inicia la respuesta

                    }
                    else{  

                        currentLine = "";

                    }
                }
                else if (c != '\r') { 

                    currentLine += c; 

                }  
             }
         }
     }
  }




void performJSONActions(){

  if (finMensaje) {

                      String mensajeJSON = currentLine;
                      StaticJsonDocument<200> doc;
                      DeserializationError error = deserializeJson(doc, mensajeJSON);

                      if (error) {

                          Serial.print(F("deserializeJson() failed: "));
                          Serial.println(error.f_str());

                      }
                  }

}