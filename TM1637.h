//  Author:Fred.Chu
//  Date:9 April,2013
//
//  This library is free software; you can redistribute it and/or
//  modify it under the terms of the GNU Lesser General Public
//  License as published by the Free Software Foundation; either
//  version 2.1 of the License, or (at your option) any later version.
//
//  This library is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
//  Lesser General Public License for more details.
//
//  You should have received a copy of the GNU Lesser General Public
//  License along with this library; if not, write to the Free Software
//  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
//
//  Modified record:
//
/*******************************************************************************/

#ifndef TM1637_h
#define TM1637_h

#include <wiringPi.h>
#include <stdio.h>
#include <stdlib.h>

#define uint8_t unsigned char 

//************definitions for TM1637*********************

#define ADDR_AUTO  0x40
#define ADDR_FIXED 0x44

#define STARTADDR  0xc0 
/**** definitions for the clock point of the digit tube *******/
#define POINT_ON   1
#define POINT_OFF  0
/**************definitions for brightness***********************/
#define  BRIGHT_DARKEST 0
#define  BRIGHT_TYPICAL 2
#define  BRIGHTEST      7


uint8_t Cmd_SetData;
uint8_t Cmd_SetAddr;
uint8_t Cmd_DispCtrl;
void TM1637_init(uint8_t Clk, uint8_t Data);
void TM1637_writeByte(int8_t wr_data);//write 8bit data to tm1637
void TM1637_start(void);//send start bits
void TM1637_stop(void); //send stop bits

void TM1637_display_str(int8_t DispData[]);
void TM1637_display(uint8_t BitAddr,int8_t DispData);

void TM1637_clearDisplay(void);
void TM1637_set(uint8_t brightness,uint8_t SetData,uint8_t SetAddr);//To take effect the next time it displays.
void TM1637_point(uint8_t PointFlag);//whether to light the clock point ":".To take effect the next time it displays.
void TM1637_coding_str(int8_t DispData[]); 
int8_t TM1637_coding(int8_t DispData); 

#endif
