#include "TM1637.h"
  
#define clk 28  //pins definitions for TM1637 and can be changed to other ports       
#define dio 29
  
int setup()
{
  
  if(wiringPiSetup()==-1)
  {
     printf("setup wiringPi failed ! n");
     return 1;
  }
  
  pinMode(clk,INPUT);
  pinMode(dio,INPUT);
  delay(200); 
  
  TM1637_init(clk,dio);
  TM1637_set(BRIGHTEST,0x40,0xc0);//BRIGHT_TYPICAL = 2,BRIGHT_DARKEST = 0,BRIGHTEST = 7;
}
  
int main (int argc, char *argv[])
{
  
  int8_t NumTab[] = {0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15};//0~9,A,b,C,d,E,F
  int8_t ListDisp[4];
  unsigned char i = 0;
  unsigned char count = 0;
  int d1, d2, d3, d4;

  delay (150);
  setup ();

  if (argv[1])
    d1 = atoi (argv[1]);
  else
    return -1;

  if (argv[2])
    d2 = atoi (argv[2]);
  else
    return -1;

  if (argv[3])
    d3 = atoi (argv[3]);
  else
    return -1;

  if (argv[4])
    d4 = atoi (argv[4]);
  else
    return -1;


// f = 15
// p = 21 or 24
// blank is 16

  TM1637_display (0,d1);
  TM1637_display (1,d2);
  TM1637_display (2,d3);
  TM1637_display (3,d4);

}

