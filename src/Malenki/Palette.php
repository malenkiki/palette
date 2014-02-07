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
    /**
     * Red channel into RGB format.
     * 
     * @var float
     * @access protected
     */
    protected $int_r = 0;
    
    /**
     * Green channel into RGB format.
     * 
     * @var float
     * @access protected
     */
    protected $int_g = 0;

    /**
     * Blue channel into RGB format.
     * 
     * @var float
     * @access protected
     */
    protected $int_b = 0;
    /**
     * Original color format used to instanciate current object.
     * 
     * If orinal is not RGB, will be object, null otherwise.
     *
     * @var mixed
     * @access protected
     */
    protected $original = null;
    protected static $int_precision = null;
    protected $matrix_xyz = null;

    /**
     * Official and unofficial CSS color names.
     *
     * Keys are CSS name and values are the hexadecimal string RGB.
     *
     * @var array
     */
    protected static $arr_colors = array(
        'aliceblue' => '#f0f8ff',
        'antiquewhite' => '#faebd7',
        'aqua' => '#00ffff',
        'aquamarine' => '#7fffd4',
        'azure' => '#f0ffff',
        'beige' => '#f5f5dc',
        'bisque' => '#ffe4c4',
        'black' => '#000000',
        'blanchedalmond' => '#ffebcd',
        'blue' => '#0000ff',
        'blueviolet' => '#8a2be2',
        'brown' => '#a52a2a',
        'burlywood' => '#deb887',
        'cadetblue' => '#5f9ea0',
        'chartreuse' => '#7fff00',
        'chocolate' => '#d2691e',
        'coral' => '#ff7f50',
        'cornflowerblue' => '#6495ed',
        'cornsilk' => '#fff8dc',
        'crimson' => '#dc143c',
        'cyan' => '#00ffff',
        'darkblue' => '#00008b',
        'darkcyan' => '#008b8b',
        'darkgoldenrod' => '#b8860b',
        'darkgray' => '#a9a9a9',
        'darkgreen' => '#006400',
        'darkkhaki' => '#bdb76b',
        'darkmagenta' => '#8b008b',
        'darkolivegreen' => '#556b2f',
        'darkorange' => '#ff8c00',
        'darkorchid' => '#9932cc',
        'darkred' => '#8b0000',
        'darksalmon' => '#e9967a',
        'darkseagreen' => '#8fbc8f',
        'darkslateblue' => '#483d8b',
        'darkslategray' => '#2f4f4f',
        'darkturquoise' => '#00ced1',
        'darkviolet' => '#9400d3',
        'deeppink' => '#ff1493',
        'deepskyblue' => '#00bfff',
        'dimgray' => '#696969',
        'dodgerblue' => '#1e90ff',
        'firebrick' => '#b22222',
        'floralwhite' => '#fffaf0',
        'forestgreen' => '#228b22',
        'fuchsia' => '#ff00ff',
        'gainsboro' => '#dcdcdc',
        'ghostwhite' => '#f8f8ff',
        'gold' => '#ffd700',
        'goldenrod' => '#daa520',
        'gray' => '#808080',
        'green' => '#008000',
        'greenyellow' => '#adff2f',
        'honeydew' => '#f0fff0',
        'hotpink' => '#ff69b4',
        'indianred' => '#cd5c5c',
        'indigo' => '#4b0082',
        'ivory' => '#fffff0',
        'khaki' => '#f0e68c',
        'lavender' => '#e6e6fa',
        'lavenderblush' => '#fff0f5',
        'lawngreen' => '#7cfc00',
        'lemonchiffon' => '#fffacd',
        'lightblue' => '#add8e6',
        'lightcoral' => '#f08080',
        'lightcyan' => '#e0ffff',
        'lightgoldenrodyellow' => '#fafad2',
        'lightgray' => '#d3d3d3',
        'lightgreen' => '#90ee90',
        'lightpink' => '#ffb6c1',
        'lightsalmon' => '#ffa07a',
        'lightseagreen' => '#20b2aa',
        'lightskyblue' => '#87cefa',
        'lightslategray' => '#778899',
        'lightsteelblue' => '#b0c4de',
        'lightyellow' => '#ffffe0',
        'lime' => '#00ff00',
        'limegreen' => '#32cd32',
        'linen' => '#faf0e6',
        'magenta' => '#ff00ff',
        'maroon' => '#800000',
        'mediumaquamarine' => '#66cdaa',
        'mediumblue' => '#0000cd',
        'mediumorchid' => '#ba55d3',
        'mediumpurple' => '#9370db',
        'mediumseagreen' => '#3cb371',
        'mediumslateblue' => '#7b68ee',
        'mediumspringgreen' => '#00fa9a',
        'mediumturquoise' => '#48d1cc',
        'mediumvioletred' => '#c71585',
        'midnightblue' => '#191970',
        'mintcream' => '#f5fffa',
        'mistyrose' => '#ffe4e1',
        'moccasin' => '#ffe4b5',
        'navajowhite' => '#ffdead',
        'navy' => '#000080',
        'oldlace' => '#fdf5e6',
        'olive' => '#808000',
        'olivedrab' => '#6b8e23',
        'orange' => '#ffa500',
        'orangered' => '#ff4500',
        'orchid' => '#da70d6',
        'palegoldenrod' => '#eee8aa',
        'palegreen' => '#98fb98',
        'paleturquoise' => '#afeeee',
        'palevioletred' => '#db7093',
        'papayawhip' => '#ffefd5',
        'peachpuff' => '#ffdab9',
        'peru' => '#cd853f',
        'pink' => '#ffc0cb',
        'plum' => '#dda0dd',
        'powderblue' => '#b0e0e6',
        'purple' => '#800080',
        'red' => '#ff0000',
        'rosybrown' => '#bc8f8f',
        'royalblue' => '#4169e1',
        'saddlebrown' => '#8b4513',
        'salmon' => '#fa8072',
        'sandybrown' => '#f4a460',
        'seagreen' => '#2e8b57',
        'seashell' => '#fff5ee',
        'sienna' => '#a0522d',
        'silver' => '#c0c0c0',
        'skyblue' => '#87ceeb',
        'slateblue' => '#6a5acd',
        'slategray' => '#708090',
        'snow' => '#fffafa',
        'springgreen' => '#00ff7f',
        'steelblue' => '#4682b4',
        'tan' => '#d2b48c',
        'teal' => '#008080',
        'thistle' => '#d8bfd8',
        'tomato' => '#ff6347',
        'turquoise' => '#40e0d0',
        'violet' => '#ee82ee',
        'wheat' => '#f5deb3',
        'white' => '#ffffff',
        'whitesmoke' => '#f5f5f5',
        'yellow' => '#ffff00',
        'yellowgreen' => '#9acd32'
    );


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



    /**
     * Defines some magic getters to get some channel color 
     * 
     * @param mixed $name 
     * @access public
     * @return float
     */
    public function __get($name)
    {
        if(in_array($name, array('r','g','b','c','m','y','k','h','s','l','v','x','y','z')))
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
                if(
                    is_object($this->original)
                    &&
                    in_array($this->original->type, array('hsl','hsv'))
                )
                {
                    return $this->original->value->$name;
                }
                else
                {
                    return $this->hsl()->$name;
                }
            }
            elseif($name == 'l')
            {
                return $this->hsl()->$name;
            }
            elseif($name == 'v')
            {
                return $this->hsv()->$name;
            }
            elseif(in_array($name, array('x', 'y', 'z')))
            {
                return $this->xyz()->$name;
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
        $mat_conv = new Math\Matrix(3, 3);
        $mat_conv
            ->addRow(array(0.412453, 0.357580, 0.180423))
            ->addRow(array(0.212671, 0.715160, 0.072169))
            ->addRow(array(0.019334, 0.119193, 0.950227))
            ;

        $this->matrix_xyz = $mat_conv;
        
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
            // XYZ
            elseif(isset($mix_param_1->x))
            {
                //TODO Add test
                $this->fromXyz($mix_param_1->x, $mix_param_1->y, $mix_param_1->z);
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
            elseif(
                is_string($mix_param_1)
                &&
                array_key_exists(
                    preg_replace('/[^a-z]/', '', strtolower($mix_param_1)),
                    self::$arr_colors
                )
            )
            {
                $arr = str_split(
                    preg_replace(
                        '/[^0-9A-Fa-f]/',
                        '',
                        self::$arr_colors[
                            preg_replace('/[^a-z]/', '', strtolower($mix_param_1))
                        ]
                    ),
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
        $this->original = new \stdClass();
        $this->original->type = 'hsl';
        $this->original->value = new \stdClass();
        $this->original->value->h = $float_h;
        $this->original->value->s = $float_s;
        $this->original->value->l = $float_l;

        $float_chroma = $float_s * (1 - abs(2 * $float_l - 1));
        $float_hp = $float_h / 60;
        $float_x = $float_chroma * (1 - abs(fmod($float_hp, 2) - 1));
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
     * Outputs as HSL values. 
     * 
     * @access public
     * @return \stdClass
     */
    public function hsl()
    {
        if(is_object($this->original) && $this->original->type == 'hsl')
        {
            return $this->original->value;
        }

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
        $this->original = new \stdClass();
        $this->original->type = 'hsv';
        $this->original->value = new \stdClass();
        $this->original->value->h = $float_h;
        $this->original->value->s = $float_s;
        $this->original->value->v = $float_v;

        $float_chroma = $float_s * $float_v;
        $float_hp = $float_h / 60;
        $float_x = $float_chroma * (1 - abs(fmod($float_hp, 2) - 1));
        $float_m = $float_v - $float_chroma;

        /*if($float_h == 0 && $float_s == 0 && $float_v == 0)
        {
            $float_rp = $float_gp = $float_bp = 0;
        }
        else*/if($float_h >= 0 && $float_h < 60)
        {
            $float_rp = $float_chroma;
            $float_gp = $float_x;
            $float_bp = 0;
        }
        elseif($float_h >= 60 && $float_h < 120)
        {
            $float_rp = $float_x;
            $float_gp = $float_chroma;
            $float_bp = 0;
        }
        elseif($float_h >= 120 && $float_h < 180)
        {
            $float_rp = 0;
            $float_gp = $float_chroma;
            $float_bp = $float_x;
        }
        elseif($float_h >= 180 && $float_h < 240)
        {
            $float_rp = 0;
            $float_gp = $float_x;
            $float_bp = $float_chroma;
        }
        elseif($float_h >= 240 && $float_h < 300)
        {
            $float_rp = $float_x;
            $float_gp = 0;
            $float_bp = $float_chroma;
        }
        elseif($float_h >= 300 && $float_h < 360)
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
     * Gets HSV values for the current color. 
     * 
     * @access public
     * @return \stdClass
     */
    public function hsv()
    {
        if(is_object($this->original) && $this->original->type == 'hsv')
        {
            return $this->original->value;
        }

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



    /**
     * Gets XYZ values using D65 white point. 
     * 
     * @access public
     * @return \stdClass
     */
    public function xyz()
    {
        if(is_object($this->original) && $this->original->type == 'xyz')
        {
            return $this->original->value;
        }


        $xyz = new \stdClass();

        $mat_rgb = new Math\Matrix(3, 1);
        $mat_rgb->addCol(
            array($this->int_r / 255, $this->int_g / 255, $this->int_b / 255)
        );

        $arr_xyz = $this->matrix_xyz->multiply($mat_rgb)->getCol(0);

        $xyz->x = round($arr_xyz[0], 5);
        $xyz->y = round($arr_xyz[1], 5);
        $xyz->z = round($arr_xyz[2], 5);

        return $xyz;
    }
    
    
    /**
     * Creates color from XYZ system, using D65 white point.
     *
     * @see http://www.cs.rit.edu/~ncs/color/t_convert.html#RGB%20to%20XYZ%20&%20XYZ%20to%20RGB 
     * @see http://www.easyrgb.com/index.php?X=DELT
     * 
     * @param mixed $float_x X value
     * @param mixed $float_y Y value
     * @param mixed $float_z Z value
     * @access protected
     * @return void
     */
    protected function fromXyz($float_x, $float_y, $float_z)
    {
        $this->original = new \stdClass();
        $this->original->type = 'xyz';
        $this->original->value = new \stdClass();
        $this->original->value->x = $float_x;
        $this->original->value->y = $float_y;
        $this->original->value->z = $float_z;
        
        $mat_xyz = new Math\Matrix(3, 1);
        $mat_xyz->addCol(array($float_x, $float_y, $float_z));
        
        $arr_rgb = $this->matrix_xyz->inverse()->multiply($mat_xyz)->multiply(255)->getCol(0);

        $this->int_r = abs(round($arr_rgb[0]));
        $this->int_g = abs(round($arr_rgb[1]));
        $this->int_b = abs(round($arr_rgb[2]));
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
        $this->original = new \stdClass();
        $this->original->type = 'cmyk';
        $this->original->value = new \stdClass();
        $this->original->value->c = $float_c;
        $this->original->value->m = $float_m;
        $this->original->value->y = $float_y;
        $this->original->value->k = $float_k;

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
        if(is_object($this->original) && $this->original->type == 'cmyk')
        {
            return $this->original->value;
        }

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
        return sprintf(
            '#%02X%02X%02X',
            $this->int_r,
            $this->int_g,
            $this->int_b
        );
    }

    public function isStandardCss()
    {
    }

    public function isExtendedCss()
    {
    }



    /**
     * Tests whether the current color is CSS color. 
     * 
     * @access public
     * @return boolean
     */
    public function isCss()
    {
        return !is_null($this->cssName());
    }



    /**
     * Gets the CSS name if it is one of them. 
     * 
     * @access public
     * @return mixed CSS color name if found or null
     */
    public function cssName()
    {
        $str_hex = strtolower($this->hex());

        foreach(self::$arr_colors as $name => $hex)
        {
            if($hex == $str_hex)
            {
                return $name;
            }
        }

        return null;
    }



    /**
     * Gets complementary color.
     * 
     * Returns new Palette object for the complementary color.
     *
     * @access public
     * @return Palette
     */
    public function complementary()
    {
        $complementary = new \stdClass();

        if(
            is_object($this->original)
            &&
            in_array($this->original->type, array('hsl', 'hsv'))
        )
        {
            $complementary = $this->original->value;
        }
        else
        {
            $complementary = $this->hsl();
        }


        if($complementary->h < 180)
        {
            $complementary->h = $complementary->h + 180;
        }
        else
        {
            $complementary->h = $complementary->h - 180;
        }

        return new self($complementary);
    }



    public function isSimilar(Palette $color)
    {
    }


    /**
     * In string context, print color as hexadecimal string. 
     * 
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->hex();
    }
}
