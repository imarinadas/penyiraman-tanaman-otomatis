#include "WiFiEsp.h"
#include "SoftwareSerial.h"
// SoftwareSerial ESPserial(2, 3); // pin RX | TX

// untuk koneksi ke Wi Fi
char ssid[] = "abcde"; // isi dengan nama profile wifi
char pass[] = "uwuuuuuu"; // isi password wifi
char server[] = "http://wateringsystem.epizy.com/"; // isi server hosting

// inisialisasi Pin yang digunakan
int sensorPin = A0;
int WATERPUMP = 13; // motor pump terkoneksi ke pin 13

bool statusKomunikasiWifi = false; // cek berhasil komunikasi
bool responDariServer = false; // cek jika ada respon server
unsigned long waktuMulaiMintaData; // periode mulai pengambilan data dari server
unsigned long waktuMintaData = 5000; // minta data setiap 5000ms
WiFiEspClient client; // client server
int status = WL_IDLE_STATUS; // status Wi Fi

String respon = ""; // penampung data respon dari server 
String mode1 = "0"; // mode 1 aktif atau tidak
String mode2 = "0"; // mode 2 aktif atau tidak
unsigned long waktuJadwal; // periode waktu yang ditentukan user
unsigned long waktuMulaiJadwal; // periode mulai waktu berjalan
bool sudahAmbilMode = false; // cek apabila sudah ambil data server

void setup() {
  Serial.begin(9600);

  /*
  Serial.println("Koneksi arduino dengan mySql menggunakan ESp8266 dan XAMPP");

  ESPserial.begin(115200);
  WiFi.init(&ESPserial);

  // attempt to connect to WiFi network
  while ( status != WL_CONNECTED) {
    Serial.print("Attempting to connect to WPA SSID: ");
    Serial.println(ssid);
    // Connect to WPA/WPA2 network
    status = WiFi.begin(ssid, pass);
  }

  // you're connected now, so print out the data
  Serial.println("You're connected to the network");
  */

  // inisialisasi waktu mulai ambil data
  waktuMulaiMintaData = millis();
  waktuMulaiJadwal = millis();

  // inisialisasi Pin
  pinMode(WATERPUMP, OUTPUT); //mengatur pin 13 agar menjadi output
  pinMode(sensorPin, INPUT); // mengatur pin 8 menjadi input, untuk menginisialisasu ke port serial
}

void loop() {
  /*
  // proses pengambilan data dari server
  if (waktuMintaData <= millis() - waktuMulaiMintaData)
  {
    statusKomunikasiWifi = ambilDatabase();
    waktuMulaiMintaData = millis();
  }

  // proses konversi hasil data server ke variabel respon
  if (statusKomunikasiWifi)
  {
    // if there are incoming bytes available
    // from the server, read them and print them
    respon = "";
    while (client.available())
    {
      char c = client.read();
      respon += c;
    }

    // if the server's disconnected, stop the client
    if (!client.connected()) {
      Serial.println("Disconnecting from server...");
      client.stop();
      statusKomunikasiWifi = false;
      responDariServer = true;
    }
  }

  // penanganan data yang diretima dari server
  if (responDariServer)
  {
    responDariServer = false;
    //Serial.println(respon);
    int posisiData = respon.indexOf("\r\n\r\n");
    String data = respon.substring(posisiData + 4);
    data.trim();

    // memecahkan data server menjadi beberapa data
    mode1 = data.substring(0, 1);
    mode2 = data.substring(2, 3);
    String waktu = data.substring(4);
    int panjang = waktu.length();
    char waktu2[panjang];
    for (int i = 0; i<panjang; i++){
      waktu2[i] = waktu[i];
    }
    waktuJadwal = atol(waktu2)*3600000;
    
    Serial.println("Data dari server");
    Serial.println(waktuJadwal);
    Serial.println(mode1);
    Serial.println(mode2);

    sudahAmbilMode = true;
  }
  */
  
  // inisialisasi data input user secara statis
  mode1 = "1";
  mode2 = "1";
  waktuJadwal = 30000;

  sudahAmbilMode = true;
  
  // proses aktivasi fitur yang ada
  if (sudahAmbilMode) {
    float kelembaban = analogRead(sensorPin);

    Serial.print("Kelembaban tanah : ");
    Serial.println(kelembaban);

    // fitur penjadwalan
    if (mode1 == "1") {
      if (millis() - waktuMulaiJadwal >= waktuJadwal){
        Serial.println("Waktu tiba, siram air!");
        digitalWrite(WATERPUMP, HIGH);
        waktuMulaiJadwal = millis();
        delay(7500);
      }
    }
    
    // fitur sensor tanah
    if (mode2 == "1") {
      if (kelembaban >= 600 ) {
        Serial.println("Tanah kering, siram air!");
        digitalWrite(WATERPUMP, HIGH);
        delay(5000);
      }
    }
    
    digitalWrite(WATERPUMP, LOW);

    
    // mengirim log data kelembapan ke server
    /*
    statusKomunikasiWifi = kirimKeDatabase(kelembaban)
    // if the server's disconnected, stop the client
    if (!client.connected()) {
      Serial.println("Disconnecting from server...");
      client.stop();
      statusKomunikasiWifi = false;
    }
    */
  }
  delay(500);
}

/*
bool ambilDatabase()
{
  Serial.println();
  Serial.println("Starting connection to server...");
  // if you get a connection, report back via serial
  if (client.connect(server, 80)) {
    Serial.println("Connected to server");
    // Make a HTTP request
    client.print("GET /arduino_mysql/arduino_process.php?mode=mode");
    client.println(" HTTP/1.1");
    client.print("Host: ");
    client.println(server);
    client.println("Connection: close");
    client.println();

    long _startMillis = millis();
    while (!client.available() and (millis() - _startMillis < 2000));

    return true;
  }
  return false;
}
*/


/*
bool kirimKeDatabase(float humidity)
{
  Serial.println();
  Serial.println("Starting connection to server...");
  // if you get a connection, report back via serial
  if (client.connect(server, 80)) {
    Serial.println("Connected to server");
    // Make a HTTP request

    // parameter 1
    client.print("GET /arduino_mysql/arduino_process.php?");
    client.print("humidity=");
    client.print(humidity);

    client.println(" HTTP/1.1");
    client.print("Host: ");
    client.println(server);
    client.println("Connection: close");
    client.println();

    return true;
  }
  return false;
}
*/
