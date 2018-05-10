#include <stdbool.h>
#include <stddef.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "qrcodegen.h"
#include "qdbmp.h"
#include <math.h>

// Function prototypes
static void doBasicDemo(char *str);
void saveQr(const uint8_t qrcode[], char * str);

// The main application program.
int main(int argc, char **  argv) {
	doBasicDemo(argv[1]);
	return 1;
}

/*---- Demo suite ----*/

// Creates a single QR Code, then prints it to the console.
static void doBasicDemo(char * str) {
	const char *text = str;  // User-supplied text
	enum qrcodegen_Ecc errCorLvl = qrcodegen_Ecc_LOW;  // Error correction level

	// Make and print the QR Code symbol
	uint8_t qrcode[qrcodegen_BUFFER_LEN_MAX];
	uint8_t tempBuffer[qrcodegen_BUFFER_LEN_MAX];
	bool ok = qrcodegen_encodeText(text, tempBuffer, qrcode, errCorLvl,
		qrcodegen_VERSION_MIN, qrcodegen_VERSION_MAX, qrcodegen_Mask_AUTO, true);
	if (ok)
		saveQr(qrcode,str);
}

void saveQr(const uint8_t qrcode[], char * str){
    UINT x,y;
    int xa = 0,ya = 0;
    int xb = 0,yb = 0;
    int norm = 500; //px
    UINT size = qrcodegen_getSize(qrcode);
    int mult = (int)round(norm/size);
    int i;
    BMP* qRcode = BMP_Create( size*mult, size*mult, 8 );
    for (i=0; i<256; i++)
        BMP_SetPaletteColor(qRcode, i, i,i,i);
    for (y = 0; y < size; y++){        // boucle sur la tableau du QRCODE
		for (x = 0; x < size; x++){    // boucle sur la tableau du QRCODE
            for( xb = 0 ; xb < mult ; xb++ ){
                for( yb = 0 ; yb < mult ; yb++ ){
                    if(qrcodegen_getModule(qrcode, x, y)){
                        BMP_SetPixelIndex( qRcode, xa+xb, ya+yb, 0 );
                    }else{
                        BMP_SetPixelIndex( qRcode, xa+xb, ya+yb, 255 );
                    }
                }
            }
            //printf("xa : %d , ya : %d \n",xa,ya);
            xa+=mult;
		}
		xa = 0;
		ya+=mult;
    }
    char * file  = malloc(strlen(str)+12);
    sprintf(file,"Qrcode_%s.bmp",str);
    BMP_WriteFile( qRcode, file );
    BMP_Free( qRcode );
}
