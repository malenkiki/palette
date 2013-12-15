<?php
/*
Copyright (c) 2013 Michel Petit <petit.michel@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */


(@include_once __DIR__ . '/../vendor/autoload.php') || @include_once __DIR__ . '/../../../autoload.php';

class PaletteTest extends PHPUnit_Framework_TestCase
{


    public function testRgb()
    {
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 0;
        $rgb->b = 0;

        $p = new Malenki\Palette(0,0,0);
        $this->assertEquals($rgb, $p->rgb());
    }


    public function testHex()
    {
        $p = new Malenki\Palette(0,0,0);
        $this->assertEquals('#000000', $p->hex());
        
        $p = new Malenki\Palette(255,255,255);
        $this->assertEquals('#FFFFFF', $p->hex());
    }


    public function testFromHsl()
    {
        // black
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 0;

        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 0;
        $rgb->b = 0;

        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
        
        // white
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 1;

        $rgb = new \stdClass();
        $rgb->r = 255;
        $rgb->g = 255;
        $rgb->b = 255;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
        
        // red
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 1;
        $hsl->l = 1/2;
        
        $rgb = new \stdClass();
        $rgb->r = 255;
        $rgb->g = 0;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());

        // lime
        $hsl = new \stdClass();
        $hsl->h = 120;
        $hsl->s = 1;
        $hsl->l = 1/2;
        
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 255;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());

        // blue
        $hsl = new \stdClass();
        $hsl->h = 240;
        $hsl->s = 1;
        $hsl->l = 1/2;
        
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 0;
        $rgb->b = 255;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());

        // Yellow
        $hsl = new \stdClass();
        $hsl->h = 60;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $rgb = new \stdClass();
        $rgb->r = 255;
        $rgb->g = 255;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());

        // Cyan
        $hsl = new \stdClass();
        $hsl->h = 180;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 255;
        $rgb->b = 255;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Magenta
        $hsl = new \stdClass();
        $hsl->h = 300;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $rgb = new \stdClass();
        $rgb->r = 255;
        $rgb->g = 0;
        $rgb->b = 255;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Silver
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 0.75;
        $rgb = new \stdClass();
        $rgb->r = 192;
        $rgb->g = 192;
        $rgb->b = 192;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Gray
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 0.5;
        $rgb = new \stdClass();
        $rgb->r = 128;
        $rgb->g = 128;
        $rgb->b = 128;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Maroon
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $rgb = new \stdClass();
        $rgb->r = 128;
        $rgb->g = 0;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Olive
        $hsl = new \stdClass();
        $hsl->h = 60;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $rgb = new \stdClass();
        $rgb->r = 128;
        $rgb->g = 128;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Green
        $hsl = new \stdClass();
        $hsl->h = 120;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 128;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Purple
        $hsl = new \stdClass();
        $hsl->h = 300;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $rgb = new \stdClass();
        $rgb->r = 128;
        $rgb->g = 0;
        $rgb->b = 128;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Teal
        $hsl = new \stdClass();
        $hsl->h = 180;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 128;
        $rgb->b = 128;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    
        // Navy
        $hsl = new \stdClass();
        $hsl->h = 240;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 0;
        $rgb->b = 128;
        $p = new Malenki\Palette($hsl);
        $this->assertEquals($rgb, $p->rgb());
    }

    public function testHsl()
    {
        Malenki\Palette::precision(2);
        // black
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 0;

        $p = new Malenki\Palette(0,0,0);
        $this->assertEquals($hsl, $p->hsl());

        // white
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 1;
        $p = new Malenki\Palette(255,255,255);
        $this->assertEquals($hsl, $p->hsl());

        // red
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $p = new Malenki\Palette(255,0,0);
        $this->assertEquals($hsl, $p->hsl());

        // lime
        $hsl = new \stdClass();
        $hsl->h = 120;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $p = new Malenki\Palette(0,255,0);
        $this->assertEquals($hsl, $p->hsl());

        // blue
        $hsl = new \stdClass();
        $hsl->h = 240;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $p = new Malenki\Palette(0,0,255);
        $this->assertEquals($hsl, $p->hsl());

        // Yellow
        $hsl = new \stdClass();
        $hsl->h = 60;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $p = new Malenki\Palette(255, 255, 0);
        $this->assertEquals($hsl, $p->hsl());

        // Cyan
        $hsl = new \stdClass();
        $hsl->h = 180;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $p = new Malenki\Palette(0, 255, 255);
        $this->assertEquals($hsl, $p->hsl());
        // Magenta
        $hsl = new \stdClass();
        $hsl->h = 300;
        $hsl->s = 1;
        $hsl->l = 1/2;
        $p = new Malenki\Palette(255, 0, 255);
        $this->assertEquals($hsl, $p->hsl());
        // Silver
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 0.75;
        $p = new Malenki\Palette(192, 192, 192);
        $this->assertEquals($hsl, $p->hsl());
        // Gray
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 0.5;
        $p = new Malenki\Palette(128, 128, 128);
        $this->assertEquals($hsl, $p->hsl());
        // Maroon
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $p = new Malenki\Palette(128, 0, 0);
        $this->assertEquals($hsl, $p->hsl());
        // Olive
        $hsl = new \stdClass();
        $hsl->h = 60;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $p = new Malenki\Palette(128, 128, 0);
        $this->assertEquals($hsl, $p->hsl());
        // Green
        $hsl = new \stdClass();
        $hsl->h = 120;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $p = new Malenki\Palette(0, 128, 0);
        $this->assertEquals($hsl, $p->hsl());
        // Purple
        $hsl = new \stdClass();
        $hsl->h = 300;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $p = new Malenki\Palette(128, 0, 128);
        $this->assertEquals($hsl, $p->hsl());
        // Teal
        $hsl = new \stdClass();
        $hsl->h = 180;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $p = new Malenki\Palette(0, 128, 128);
        $this->assertEquals($hsl, $p->hsl());
        // Navy
        $hsl = new \stdClass();
        $hsl->h = 240;
        $hsl->s = 1;
        $hsl->l = 0.25;
        $p = new Malenki\Palette(0, 0, 128);
        $this->assertEquals($hsl, $p->hsl());
    }



    public function testFromHsv()
    {
        // black
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 0;

        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 0;
        $rgb->b = 0;

        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());

        // white
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 1;
        
        $rgb = new \stdClass();
        $rgb->r = 255;
        $rgb->g = 255;
        $rgb->b = 255;

        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // red
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 1;
        $hsv->v = 1;
        
        $rgb = new \stdClass();
        $rgb->r = 255;
        $rgb->g = 0;
        $rgb->b = 0;

        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());

        // lime
        $hsv = new \stdClass();
        $hsv->h = 120;
        $hsv->s = 1;
        $hsv->v = 1;
        
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 255;
        $rgb->b = 0;

        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // blue
        $hsv = new \stdClass();
        $hsv->h = 240;
        $hsv->s = 1;
        $hsv->v = 1;
        
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 0;
        $rgb->b = 255;

        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Yellow
        $hsv = new \stdClass();
        $hsv->h = 60;
        $hsv->s = 1;
        $hsv->v = 1;
        
        $rgb = new \stdClass();
        $rgb->r = 255;
        $rgb->g = 255;
        $rgb->b = 0;

        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Cyan
        $hsv = new \stdClass();
        $hsv->h = 180;
        $hsv->s = 1;
        $hsv->v = 1;
        
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 255;
        $rgb->b = 255;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Magenta
        $hsv = new \stdClass();
        $hsv->h = 300;
        $hsv->s = 1;
        $hsv->v = 1;
        
        $rgb = new \stdClass();
        $rgb->r = 255;
        $rgb->g = 0;
        $rgb->b = 255;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());

        
        // Silver
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 0.75;
        
        $rgb = new \stdClass();
        $rgb->r = 192;
        $rgb->g = 192;
        $rgb->b = 192;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());

        
        // Gray
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 0.5;
        
        $rgb = new \stdClass();
        $rgb->r = 128;
        $rgb->g = 128;
        $rgb->b = 128;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Maroon
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 1;
        $hsv->v = 0.5;
        
        $rgb = new \stdClass();
        $rgb->r = 128;
        $rgb->g = 0;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Olive
        $hsv = new \stdClass();
        $hsv->h = 60;
        $hsv->s = 1;
        $hsv->v = 0.5;
        
        $rgb = new \stdClass();
        $rgb->r = 128;
        $rgb->g = 128;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Green
        $hsv = new \stdClass();
        $hsv->h = 120;
        $hsv->s = 1;
        $hsv->v = 0.5;
        
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 128;
        $rgb->b = 0;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Purple
        $hsv = new \stdClass();
        $hsv->h = 300;
        $hsv->s = 1;
        $hsv->v = 0.5;
        
        $rgb = new \stdClass();
        $rgb->r = 128;
        $rgb->g = 0;
        $rgb->b = 128;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Teal
        $hsv = new \stdClass();
        $hsv->h = 180;
        $hsv->s = 1;
        $hsv->v = 0.5;
        
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 128;
        $rgb->b = 128;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


        // Navy
        $hsv = new \stdClass();
        $hsv->h = 240;
        $hsv->s = 1;
        $hsv->v = 0.5;
        
        $rgb = new \stdClass();
        $rgb->r = 0;
        $rgb->g = 0;
        $rgb->b = 128;
        $p = new Malenki\Palette($hsv);
        $this->assertEquals($rgb, $p->rgb());


    }


    public function testHsv()
    {
        Malenki\Palette::precision(2);
        // black
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 0;
        $p = new Malenki\Palette(0,0,0);
        $this->assertEquals($hsv, $p->hsv());

        // white
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 1;
        $p = new Malenki\Palette(255,255,255);
        $this->assertEquals($hsv, $p->hsv());

        // red
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 1;
        $hsv->v = 1;
        $p = new Malenki\Palette(255,0,0);
        $this->assertEquals($hsv, $p->hsv());

        // lime
        $hsv = new \stdClass();
        $hsv->h = 120;
        $hsv->s = 1;
        $hsv->v = 1;
        $p = new Malenki\Palette(0,255,0);
        $this->assertEquals($hsv, $p->hsv());

        // blue
        $hsv = new \stdClass();
        $hsv->h = 240;
        $hsv->s = 1;
        $hsv->v = 1;
        $p = new Malenki\Palette(0,0,255);
        $this->assertEquals($hsv, $p->hsv());

        // Yellow
        $hsv = new \stdClass();
        $hsv->h = 60;
        $hsv->s = 1;
        $hsv->v = 1;
        $p = new Malenki\Palette(255, 255, 0);
        $this->assertEquals($hsv, $p->hsv());

        // Cyan
        $hsv = new \stdClass();
        $hsv->h = 180;
        $hsv->s = 1;
        $hsv->v = 1;
        $p = new Malenki\Palette(0, 255, 255);
        $this->assertEquals($hsv, $p->hsv());
        // Magenta
        $hsv = new \stdClass();
        $hsv->h = 300;
        $hsv->s = 1;
        $hsv->v = 1;
        $p = new Malenki\Palette(255, 0, 255);
        $this->assertEquals($hsv, $p->hsv());
        // Silver
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 0.75;
        $p = new Malenki\Palette(192, 192, 192);
        $this->assertEquals($hsv, $p->hsv());
        // Gray
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 0.5;
        $p = new Malenki\Palette(128, 128, 128);
        $this->assertEquals($hsv, $p->hsv());
        // Maroon
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 1;
        $hsv->v = 0.5;
        $p = new Malenki\Palette(128, 0, 0);
        $this->assertEquals($hsv, $p->hsv());
        // Olive
        $hsv = new \stdClass();
        $hsv->h = 60;
        $hsv->s = 1;
        $hsv->v = 0.5;
        $p = new Malenki\Palette(128, 128, 0);
        $this->assertEquals($hsv, $p->hsv());
        // Green
        $hsv = new \stdClass();
        $hsv->h = 120;
        $hsv->s = 1;
        $hsv->v = 0.5;
        $p = new Malenki\Palette(0, 128, 0);
        $this->assertEquals($hsv, $p->hsv());
        // Purple
        $hsv = new \stdClass();
        $hsv->h = 300;
        $hsv->s = 1;
        $hsv->v = 0.5;
        $p = new Malenki\Palette(128, 0, 128);
        $this->assertEquals($hsv, $p->hsv());
        // Teal
        $hsv = new \stdClass();
        $hsv->h = 180;
        $hsv->s = 1;
        $hsv->v = 0.5;
        $p = new Malenki\Palette(0, 128, 128);
        $this->assertEquals($hsv, $p->hsv());
        // Navy
        $hsv = new \stdClass();
        $hsv->h = 240;
        $hsv->s = 1;
        $hsv->v = 0.5;
        $p = new Malenki\Palette(0, 0, 128);
        $this->assertEquals($hsv, $p->hsv());
    }

    public function testCmyk()
    {
        // Black
        $cmyk = new \stdClass();
        $cmyk->c = 0;
        $cmyk->m = 0;
        $cmyk->y = 0;
        $cmyk->k = 1;

        $p = new Malenki\Palette(0,0,0);
        $this->assertEquals($cmyk, $p->cmyk());

        // White
        $cmyk = new \stdClass();
        $cmyk->c = 0;
        $cmyk->m = 0;
        $cmyk->y = 0;
        $cmyk->k = 0;

        $p = new Malenki\Palette(0xff,0xff,0xff);
        $this->assertEquals($cmyk, $p->cmyk());

        // Red
        $cmyk = new \stdClass();
        $cmyk->c = 0;
        $cmyk->m = 1;
        $cmyk->y = 1;
        $cmyk->k = 0;

        $p = new Malenki\Palette(0xff,0,0);
        $this->assertEquals($cmyk, $p->cmyk());

        // Green
        $cmyk = new \stdClass();
        $cmyk->c = 1;
        $cmyk->m = 0;
        $cmyk->y = 1;
        $cmyk->k = 0;

        $p = new Malenki\Palette(0, 0xff,0);
        $this->assertEquals($cmyk, $p->cmyk());

        // Blue
        $cmyk = new \stdClass();
        $cmyk->c = 1;
        $cmyk->m = 1;
        $cmyk->y = 0;
        $cmyk->k = 0;

        $p = new Malenki\Palette(0, 0, 0xff);
        $this->assertEquals($cmyk, $p->cmyk());
        
        // Yellow
        $cmyk = new \stdClass();
        $cmyk->c = 0;
        $cmyk->m = 0;
        $cmyk->y = 1;
        $cmyk->k = 0;

        $p = new Malenki\Palette(0xff, 0xff, 0);
        $this->assertEquals($cmyk, $p->cmyk());
        
        // Cyan
        $cmyk = new \stdClass();
        $cmyk->c = 1;
        $cmyk->m = 0;
        $cmyk->y = 0;
        $cmyk->k = 0;

        $p = new Malenki\Palette(0, 0xff, 0xff);
        $this->assertEquals($cmyk, $p->cmyk());
        
        // Magenta
        $cmyk = new \stdClass();
        $cmyk->c = 0;
        $cmyk->m = 1;
        $cmyk->y = 0;
        $cmyk->k = 0;

        $p = new Malenki\Palette(0xff, 0, 0xff);
        $this->assertEquals($cmyk, $p->cmyk());
    }

}
