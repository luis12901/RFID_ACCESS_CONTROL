

void prototypeFunctions(){

  bool WifiConnected();

  bool ServerConnected();

  bool beginNetworking();

  void interfaceInit();

  void conexionURL(int counter, char* mensajeJSON, char* servidor, bool pruebas);

  void postJSONToServer();

  void validateCardPresence();

  void getRFIDData();

}