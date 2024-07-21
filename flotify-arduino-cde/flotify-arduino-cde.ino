#include <WiFiS3.h>
#include "arduino_secrets.h"
#include <SoftwareSerial.h>
#include "dataHandler.h"
#include <ArduinoHttpClient.h>
#include <TinyGPSPlus.h>
#include "DHT.h"

#define RX_Ultrasonic 13
#define TX_Ultrasonic 12
#define RAIN_sensor A0
#define WATERLevel_sensor A1
#define DHTPIN 2
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);

static const int RXPin = 5, TXPin = 6;
static const uint32_t GPSBaud = 9600;

extern const char PHPGetProcess[] PROGMEM;
SoftwareSerial HM10(8, 9);

char ssid[] = SECRET_SSID;
char pass[] = SECRET_PASS;
int keyIndex = 0;

unsigned long previousMillis = 0;
const long interval = 1000;

long duration, distance;
int rainValues = analogRead(RAIN_sensor);
String rainIntensity = "";

enum SensorState
{
  READ_ULTRASONIC,
  READ_RAIN,
  READ_WATER_LEVEL,
  READ_DHT
};
SensorState sensorState = READ_ULTRASONIC;

int status = WL_IDLE_STATUS;
WiFiServer server(80);
WiFiClient client;

void setup()
{
  Serial.begin(9600);
  HM10.begin(9600);
  dht.begin();
  HM10.println("HELLLO");
  pinMode(TX_Ultrasonic, OUTPUT);
  pinMode(RX_Ultrasonic, INPUT);
  pinMode(RAIN_sensor, INPUT);
  pinMode(WATERLevel_sensor, INPUT);

  if (WiFi.status() == WL_NO_SHIELD)
  {
    Serial.println("Communication with WiFi module failed!");
    while (true)
      ;
  }

  String fv = WiFi.firmwareVersion();
  if (fv < WIFI_FIRMWARE_LATEST_VERSION)
  {
    Serial.println("Please upgrade the firmware");
  }

  while (status != WL_CONNECTED)
  {
    Serial.print("Attempting to connect to Network named: ");
    Serial.println(ssid);

    status = WiFi.begin(ssid, pass);
    delay(10000);
  }
  server.begin();
  printWiFiStatus();
}


void printWiFiStatus()
{
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
  Serial.print("To see this page in action, open a browser to http://");
  Serial.println(ip);
}

void loop()
{
  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis >= interval)
  {
    previousMillis = currentMillis;

    switch (sensorState)
    {
    case READ_ULTRASONIC:
      readUltrasonic();
      sensorState = READ_RAIN;
      break;
    case READ_RAIN:
      readRainSensor();
      sensorState = READ_WATER_LEVEL;
      break;
    case READ_WATER_LEVEL:
      readWaterLevelSensor();
      sensorState = READ_DHT;
      break;
    case READ_DHT:
      readDHTSensor();
      sensorState = READ_ULTRASONIC;
      break;
    }
  }
  int humidity = dht.readHumidity();
  int temperature = dht.readTemperature();
  WiFiClient client = server.available();
  if (client)
  {
    Serial.println("New Client.");
    String currentLine = "";
    String request = "";
    while (client.connected())
    {
      if (client.available())
      {
        char c = client.read();
        Serial.write(c);
        request += c;

        if (c == '\n')
        {
          if (currentLine.length() == 0)
          {
            if (request.indexOf("GET /sensorValues") >= 0)
            {
  String jsonResponse = "{\"rainAnalog\": " + String(rainValues) +
                        ", \"rainIntensity\": \"" + rainIntensity + "\"" +
                        ", \"waterlevel_ultrasonic\": " + String(distance * 0.01) +
                        ", \"temperature\": " + String(temperature) +
                        ", \"humidity\": " + String(humidity) + "}";
              client.println("HTTP/1.1 200 OK");
              client.println("Content-type:text/html");
              client.println("Access-Control-Allow-Origin: *");
              client.println();
              client.println(jsonResponse);
            }
            else
            {
              client.println("HTTP/1.1 200 OK");
              client.println("Content-type:text/html");
              client.println();

              client.print(PHPGetProcess);

              client.println();
            }
            break;
          }
          else
          {
            currentLine = "";
          }
        }
        else if (c != '\r')
        {
          currentLine += c;
        }
      }
    }
    client.stop();
    Serial.println("Client disconnected.");
  }
  String message = String(distance) + "," + String(rainValues) + "," + String(rainIntensity) + "," + String(temperature) + "," + String(humidity);
  HM10.println(message);
}

void readUltrasonic()
{
  digitalWrite(TX_Ultrasonic, LOW);
  delayMicroseconds(5);
  digitalWrite(TX_Ultrasonic, HIGH);
  delayMicroseconds(20);
  digitalWrite(TX_Ultrasonic, LOW);

  duration = pulseIn(RX_Ultrasonic, HIGH);
  distance = duration * 0.034 / 2;

  Serial.print("Distance: ");
  Serial.print(distance * 0.01);
  Serial.println(" m");
}

void readRainSensor()
{
  rainValues = analogRead(RAIN_sensor);
  Serial.print("Rain Values: ");
  Serial.println(rainValues);

  if (rainValues > 950)
  {
    rainIntensity = "No Rain";
  }
  else if (rainValues < 950 && rainValues > 750)
  {
    rainIntensity = "Light Rain";
  }
  else if (rainValues < 750 && rainValues > 550)
  {
    rainIntensity = "Moderate";
  }
  else if (rainValues < 550)
  {
    rainIntensity = "Heavy Rain";
  }
}

void readWaterLevelSensor()
{
  int criticalAlert = analogRead(WATERLevel_sensor);
  int criticalLevels = map(criticalAlert, 0, 1023, 0, 100);
  Serial.print("Critical Level: ");
  Serial.print(criticalLevels);
  Serial.println("%");

void readDHTSensor()
{
  float h = dht.readHumidity();
  float t = dht.readTemperature();

  // Check if any reads failed and exit early (to try again).
  if (isnan(h) || isnan(t))
  {
    Serial.println("Failed to read from DHT sensor!");
    return;
  }

  Serial.print("Humidity: ");
  Serial.print(h);
  Serial.print(" %\t");
  Serial.print("Temperature: ");
  Serial.print(t);
  Serial.println(" *C ");
}