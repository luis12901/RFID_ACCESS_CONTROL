
// Network Variables

  char ssid[100]     = "RFID";
  char password[100] = "123456789";

  WiFiServer servidor(80);


bool WifiConnected() {

  uint8_t secondsCounter = 0;

  Serial.print("Conectando a ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {

      delay(500);

      secondsCounter++;

      Serial.print(".");

      if(secondsCounter == 20){

          return false;
          
        }

    }
    

  
  if(!MDNS.begin("sensor")) {}
  else{

      servidor.begin();
      MDNS.addService("http", "tcp", 80);

  }


  Serial.println("");
  Serial.println("WiFi conectado");
  Serial.println("Direccion IP: ");
  Serial.println(WiFi.localIP());
  Serial.println("Direccion MAC: ");
  Serial.println(WiFi.macAddress());
  return true;

}

bool ServerConnected() {
  
  // Variables de conexión HTTP
    const char* serverIP = "http://192.168.43.122";
    WiFiClient client;
    HTTPClient http;

  
  
  http.begin(client, serverIP);
  int httpCode = http.GET();

  if (httpCode > 0) {
    
      return true;
       
  }
  else{

      return false;

  }

  http.end();

  delay(100);
    
}

