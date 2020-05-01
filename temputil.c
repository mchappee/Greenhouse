#include <wiringPi.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#define MAXTIMINGS	85
#define DHTPIN		7
int dht11_dat[5] = { 0, 0, 0, 0, 0 };
 
int *read_dht11_dat()
{
  uint8_t laststate = HIGH;
  uint8_t counter = 0;
  uint8_t j = 0, i;
  float	f; 
  static int arr[2];

  dht11_dat[0] = dht11_dat[1] = dht11_dat[2] = dht11_dat[3] = dht11_dat[4] = 0;

  pinMode (26, OUTPUT );
  digitalWrite (26, LOW );
  delay (2000);
  digitalWrite (26, HIGH );
 
  delay (2000);

  pinMode( DHTPIN, OUTPUT );
  digitalWrite( DHTPIN, LOW );
  delay( 18 );
  digitalWrite( DHTPIN, HIGH );
  delayMicroseconds( 40 );
  pinMode( DHTPIN, INPUT );
 
  for ( i = 0; i < MAXTIMINGS; i++ ) {
    counter = 0;
    while ( digitalRead( DHTPIN ) == laststate ) {
      counter++;
      delayMicroseconds( 1 );

      if ( counter == 255 ) {
        break;
      }
    }

    laststate = digitalRead( DHTPIN );
 
    if ( counter == 255 )
      break;
 
    if ( (i >= 4) && (i % 2 == 0) ) {
      dht11_dat[j / 8] <<= 1;
      if ( counter > 50 )
        dht11_dat[j / 8] |= 1;

      j++;
    }
  }
 
  if ( (j >= 40) && (dht11_dat[4] == ( (dht11_dat[0] + dht11_dat[1] + dht11_dat[2] + dht11_dat[3]) & 0xFF) ) ) {
    f = dht11_dat[2] * 9. / 5. + 32;
    arr[0] = (int)f;
    arr[1] = dht11_dat[0];
    return arr;
    //printf( "Humidity = %d.%d %% Temperature = %d.%d C (%.1f F)\n", dht11_dat[0], dht11_dat[1], dht11_dat[2], dht11_dat[3], f );
  } else  {
    arr[0] = 0;
    arr[1] = 0;
    return arr;
  }
}
 
int main( void )
{
  int *arr;

  if ( wiringPiSetup() == -1 )
    exit( 1 );
 
  while (1) {
    arr = read_dht11_dat();
    if (arr[0]) {
      printf ("%d,%d", arr[0], arr[1]);
      pinMode( DHTPIN, OUTPUT );
      digitalWrite( DHTPIN, LOW );
      pinMode (26, OUTPUT );
      digitalWrite (26, LOW );
      return 0;
    }
    delay( 1000 ); 
  }

  pinMode( DHTPIN, OUTPUT );
  digitalWrite( DHTPIN, LOW );
  pinMode (26, OUTPUT );
  digitalWrite (26, LOW );

  return(0);
}

