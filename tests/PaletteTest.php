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
    }

    public function testHsl()
    {
        $hsl = new \stdClass();
        $hsl->h = 0;
        $hsl->s = 0;
        $hsl->l = 0;

        $p = new Malenki\Palette(0,0,0);
        $this->assertEquals($hsl, $p->hsl());
    }


    public function testHsv()
    {
        $hsv = new \stdClass();
        $hsv->h = 0;
        $hsv->s = 0;
        $hsv->v = 0;
        $p = new Malenki\Palette(0,0,0);
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
