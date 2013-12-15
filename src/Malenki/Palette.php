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


namespace Malenki;


/**
 * Palette, to deal with colors!
 *
 * Palette can deal with RGB, HLS, HLV and CMYK (but not with ICC yet) colors.
 *
 * Using it is very simple:
 *  * Constructor can accept every color represntation (by array, object, string, params…).
 *  * You have magic get access to some channels.
 *  * You can test whether color is similar to another
 *  * CSS color name
 * 
 * @property-read $r Red channel of RGB
 * @property-read $g Green channel of RGB
 * @property-read $b Blue channel of RGB
 * @property-read $h Hue channel of HSL or HSV
 * @property-read $s Saturation channel of HSL or HSV
 * @property-read $l Lighness channel of HSL
 * @property-read $v Value channel of HSV
 * @property-read $c Cyan channel of CMYK
 * @property-read $m Magenta channel of CMYK
 * @property-read $y Yellow channel of CMYK
 * @property-read $k Black channel of CMYK
 * @author Michel Petit <petit.michel@gmail.com> 
 * @license MIT
 */
class Palette
{
    protected $int_r = 0;
    protected $int_g = 0;
    protected $int_b = 0;
    protected static $int_precision = null;

    public static function precision($int = 2)
    {
        if(is_integer($int) && $int >= 2)
        {
            self::$int_precision = $int;
        }
        else
        {
            throw \InvalidArgumentException('Preision must be greater or equal to 2');
        }
    }

    public function __get($name)
    {
        if(in_array($name, array('r','g','b','c','m','y','k','h','s','l','v')))
        {
            if(in_array($name, array('r', 'g', 'b')))
            {
                return $this->rgb()->$name;
            }
            elseif(in_array($name, array('c', 'm', 'y', 'k')))
            {
                return $this->cmyk()->$name;
            }
            elseif(in_array($name, array('h', 's')))
            {
                return $this->hsl()->$name;
            }
            elseif($name == 'l')
            {
                return $this->hsl()->$name;
            }
            elseif($name == 'v')
            {
                return $this->hsv()->$name;
            }
        }
    }

    protected static function mustRound()
    {
        return is_integer(self::$int_precision);
    }

    protected static function getPrecision()
    {
        return self::$int_precision;
    }



    public function __construct($mix_param_1, $mix_param_2 = null, $mix_param_3 = null, $mix_param_4 = null)
    {
        if(is_object($mix_param_1))
        {
            // RGB
            if(isset($mix_param_1->r))
            {
                //TODO Add test
                $this->int_r = $mix_param_1->r;
                $this->int_g = $mix_param_1->g;
                $this->int_b = $mix_param_1->b;
            }
            // HSL
            elseif(isset($mix_param_1->l))
            {
                //TODO Add test
                $this->fromHsl($mix_param_1->h, $mix_param_1->s, $mix_param_1->l);
            }
            // HSV
            elseif(isset($mix_param_1->v))
            {
                //TODO Add test
                $this->fromHsv($mix_param_1->h, $mix_param_1->s, $mix_param_1->v);
            }
            // CMYK
            elseif(isset($mix_param_1->k))
            {
                //TODO Add test
                $this->fromCmyk($mix_param_1->c, $mix_param_1->m, $mix_param_1->y, $mix_param_1->k);
            }
        }
        else
        {
            // Only RGB and CMYK for other ways
            // CMYK
            if(
                is_numeric($mix_param_1)
                &&
                is_numeric($mix_param_2)
                &&
                is_numeric($mix_param_3)
                &&
                is_numeric($mix_param_4)
                &&
                is_float($mix_param_1)
                &&
                is_float($mix_param_2)
                &&
                is_float($mix_param_3)
                &&
                is_float($mix_param_4)
                &&
                $mix_param_1 >= 0 && $mix_param_1 <= 1
                &&
                $mix_param_2 >= 0 && $mix_param_2 <= 1
                &&
                $mix_param_3 >= 0 && $mix_param_3 <= 1
                &&
                $mix_param_4 >= 0 && $mix_param_4 <= 1
            )
            {
                $this->fromCmyk(
                    $mix_param_1,
                    $mix_param_2,
                    $mix_param_3,
                    $mix_param_4
                );
            }
            // RGB
            elseif(
                is_numeric($mix_param_1)
                &&
                is_numeric($mix_param_2)
                &&
                is_numeric($mix_param_3)
                &&
                is_null($mix_param_4)
                &&
                is_integer($mix_param_1)
                &&
                is_integer($mix_param_2)
                &&
                is_integer($mix_param_3)
                &&
                $mix_param_1 >= 0 && $mix_param_1 <= 255
                &&
                $mix_param_2 >= 0 && $mix_param_2 <= 255
                &&
                $mix_param_3 >= 0 && $mix_param_3 <= 255
            )
            {
                $this->int_r = $mix_param_1;
                $this->int_g = $mix_param_2;
                $this->int_b = $mix_param_3;
            }
            // RGB hex string
            elseif(
                is_string($mix_param_1)
                &&
                preg_match('/#{0,1}[0-9A-Fa-f]{6}/', $mix_param_1)
            )
            {
                $arr = str_split(
                    preg_replace('/[^0-9A-Fa-f]/', '', $mix_param_1),
                    2
                );

                $this->int_r = hexdec($arr[0]);
                $this->int_g = hexdec($arr[1]);
                $this->int_b = hexdec($arr[2]);
            }
            else
            {
                throw new \InvalidArgumentException('Bad scalar values for RGB or CMYK color.');
            }
        }
    }


    /**
     * fromHsl 
     * 
     * @see http://en.wikipedia.org/wiki/HSL_color_space#Converting_to_RGB
     * @param float $float_h Angle, 0 to 360° 
     * @param float $float_s 
     * @param float $float_l 
     * @access protected
     * @return void
     */
    protected function fromHsl($float_h, $float_s, $float_l)
    {
        $float_chroma = $float_s * (1 - abs(2 * $float_l - 1));
        $float_hp = $float_h / 60;
        $float_x = $float_chroma * (1 - abs($float_hp % 2 - 1));
        $float_m = $float_l - $float_chroma / 2;

        if($float_h == 0 && $float_s == 0 && $float_l == 0)
        {
            $float_rp = $float_gp = $float_bp = 0;
        }
        elseif($float_hp < 1)
        {
            $float_rp = $float_chroma;
            $float_gp = $float_x;
            $float_bp = 0;
        }
        elseif($float_hp < 2)
        {
            $float_rp = $float_x;
            $float_gp = $float_chroma;
            $float_bp = 0;
        }
        elseif($float_hp < 3)
        {
            $float_rp = 0;
            $float_gp = $float_chroma;
            $float_bp = $float_x;
        }
        elseif($float_hp < 4)
        {
            $float_rp = 0;
            $float_gp = $float_x;
            $float_bp = $float_chroma;
        }
        elseif($float_hp < 5)
        {
            $float_rp = $float_x;
            $float_gp = 0;
            $float_bp = $float_chroma;
        }
        elseif($float_hp < 6)
        {
            $float_rp = $float_chroma;
            $float_gp = 0;
            $float_bp = $float_x;
        }

        $this->int_r = ceil(($float_rp + $float_m) * 255);
        $this->int_g = ceil(($float_gp + $float_m) * 255);
        $this->int_b = ceil(($float_bp + $float_m) * 255);
    }


    /**
     * Output as HSL values. 
     * 
     * @access public
     * @return \stdClass
     */
    public function hsl()
    {
        $hsl = new \stdClass();

        $float_r = $this->int_r / 255;
        $float_g = $this->int_g / 255;
        $float_b = $this->int_b / 255;

        $float_max = max($float_r, $float_g, $float_b);
        $float_min = min($float_r, $float_g, $float_b);
        $float_h = ($float_max + $float_min) / 2;
        $float_s = $float_h;
        $float_l = $float_h;

        if($float_max == $float_min)
        {
            $float_h = 0.0;
            $float_s = 0.0;
        }
        else
        {
            $float_delta = $float_max - $float_min;

            if($float_l > 0.5)
            {
                $float_s = $float_delta / (2 - $float_max - $float_min);
            }
            else
            {
                $float_s = $float_delta / ($float_max + $float_min);
            }


            if($float_max == $float_r)
            {
                $float_h = ($float_g - $float_b) / $float_delta;

                if($float_g < $float_b)
                {
                    $float_h += 6;
                }
            }
            elseif($float_max == $float_g)
            {
                $float_h = ($float_b - $float_r) / $float_delta + 2;
            }
            elseif($float_max == $float_b)
            {
                $float_h = ($float_r - $float_g) / $float_delta + 4;
            }

            $float_h = $float_h / 6;
        }

        if(self::mustRound())
        {
            $hsl->h = $float_h * 360;
            $hsl->l = round($float_l, self::getPrecision());
            $hsl->s = round($float_s, self::getPrecision());
        }
        else
        {
            $hsl->h = $float_h * 360;
            $hsl->l = $float_l;
            $hsl->s = $float_s;
        }

        return $hsl;
    }



    /**
     * Converts HSV values to RGB.
     * 
     * @see http://en.wikipedia.org/wiki/HSL_color_space#Converting_to_RGB
     * @param float $float_h 
     * @param float $float_s 
     * @param float $float_l 
     * @access protected
     * @return void
     */
    protected function fromHsv($float_h, $float_s, $float_v)
    {
        $float_chroma = $float_s * $float_v;
        $float_hp = $float_h / 60;
        $float_x = $float_chroma * (1 - abs($float_hp % 2 - 1));
        $float_m = $float_v - $float_chroma;

        if($float_h == 0 && $float_s == 0 && $float_v == 0)
        {
            $float_rp = $float_gp = $float_bp = 0;
        }
        elseif($float_hp < 1)
        {
            $float_rp = $float_chroma;
            $float_gp = $float_x;
            $float_bp = 0;
        }
        elseif($float_hp < 2)
        {
            $float_rp = $float_x;
            $float_gp = $float_chroma;
            $float_bp = 0;
        }
        elseif($float_hp < 3)
        {
            $float_rp = 0;
            $float_gp = $float_chroma;
            $float_bp = $float_x;
        }
        elseif($float_hp < 4)
        {
            $float_rp = 0;
            $float_gp = $float_x;
            $float_bp = $float_chroma;
        }
        elseif($float_hp < 5)
        {
            $float_rp = $float_x;
            $float_gp = 0;
            $float_bp = $float_chroma;
        }
        elseif($float_hp < 6)
        {
            $float_rp = $float_chroma;
            $float_gp = 0;
            $float_bp = $float_x;
        }

        $this->int_r = ceil(($float_rp + $float_m) * 255);
        $this->int_g = ceil(($float_gp + $float_m) * 255);
        $this->int_b = ceil(($float_bp + $float_m) * 255);
    }



    public function hsv()
    {
        $hsv = new \stdClass();

        $float_r = $this->int_r / 255;
        $float_g = $this->int_g / 255;
        $float_b = $this->int_b / 255;

        $float_max = max($float_r, $float_g, $float_b);
        $float_min = min($float_r, $float_g, $float_b);
        $float_h = $float_max;
        $float_s = $float_max;
        $float_v = $float_max;
        
        $float_delta = $float_max - $float_min;

        if($float_max)
        {
            $float_s = $float_delta / $float_max;
        }
        else
        {
            $float_s = 0.0;
        }

        if($float_max == $float_min)
        {
            $float_h = 0.0;
        }
        else
        {
            if($float_max == $float_r)
            {
                $float_h = ($float_g - $float_b) / $float_delta;

                if($float_g < $float_b)
                {
                    $float_h += 6;
                }
            }
            elseif($float_max == $float_g)
            {
                $float_h = ($float_b - $float_r) / $float_delta + 2;
            }
            elseif($float_max == $float_b)
            {
                $float_h = ($float_r - $float_g) / $float_delta + 4;
            }

            $float_h = $float_h / 6;
        }

        if(self::mustRound())
        {
            $hsv->h = $float_h * 360;
            $hsv->v = round($float_v, self::getPrecision());
            $hsv->s = round($float_s, self::getPrecision());
        }
        else
        {
            $hsv->h = $float_h * 360;
            $hsv->v = $float_v;
            $hsv->s = $float_s;
        }

        return $hsv;
    
    }


    public function rgb()
    {
        $rgb = new \stdClass();
        $rgb->r = $this->int_r;
        $rgb->g = $this->int_g;
        $rgb->b = $this->int_b;

        return $rgb;
    }



    /**
     * Converts from CMYK to obtains RGV values.
     *
     * **Note:** It is not final version! See note for cmyk() method.
     * 
     * @param float $float_c 
     * @param float $float_m 
     * @param float $float_y 
     * @param float $float_k 
     * @access protected
     * @return void
     */
    protected function fromCmyk($float_c, $float_m, $float_y, $float_k)
    {
        $func = function($float_cmyk, $float_k){
            return 255 * (1 - $float_cmyk) * (1 - $float_k);
        };

        $this->int_r = $func($float_c, $float_k);
        $this->int_g = $func($float_m, $float_k);
        $this->int_b = $func($float_y, $float_k);
    }




    /**
     * Gets CMYK color
     *
     * **Note:** It is not final version yet! To be OK, it must used ICC! 
     * 
     * @todo Use ICC file/data to have the right value.
     * @access public
     * @return \stdClass
     */
    public function cmyk()
    {
        $float_r = (float) ($this->int_r / 255);
        $float_g = (float) ($this->int_g / 255);
        $float_b = (float) ($this->int_b / 255);

        $func = function($float_rgb, $float_k){
            if($float_k == 1)
            {
                return 0;
            }
            return (1 - $float_rgb - $float_k) / (1 - $float_k);
        };

        $float_k = 1 - max($float_r, $float_g, $float_b);

        $cmyk = new \stdClass();
        $cmyk->c = $func($float_r, $float_k);
        $cmyk->m = $func($float_g, $float_k);
        $cmyk->y = $func($float_b, $float_k);
        $cmyk->k = $float_k;

        return $cmyk;
    }



    /**
     * Outputs color as hexadecimal string.
     *
     * Format used is the same as in HTML/CSS world, something like that: 
     * `#RRGGBB` where `RR`, `GG` and `BB` are the hexadecimal digit parts for 
     * *red*, *green* and *blue*.
     * 
     * @access public
     * @return string
     */
    public function hex()
    {
        return sprintf('#%02X%02X%02X', $this->int_r, $this->int_g, $this->int_b);
    }

    public function isStandardCss()
    {
    }

    public function isExtendedCss()
    {
    }

    public function cssName()
    {
    }


    public function isSimilar(Palette $color)
    {
    }
}
