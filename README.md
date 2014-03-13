# palette

Palette deals with colors!

Instanciate from RGB:

```php
$p = new \Malenki\Palette(255,0,0);
// or
$p = new \Malenki\Palette('#FF0000');
```

… or from CSS color name:

```php
$p = new \Malenki\Palette('red');
```
… or from more complicated thing like HSL:

```php
$hsl = new \stdClass(); //or named array
$hsl->h = 0;
$hsl->s = 1;
$hsl->l = 0.5;
$p = new \Malenki\Palette($hsl);
```

get values:

```php
$hsl = new \stdClass(); //or named array
$hsl->h = 0;
$hsl->s = 1;
$hsl->l = 0.5;
$p = new \Malenki\Palette($hsl);
var_dump($p->rgb());
//or
var_dump($p->r);
var_dump($p->g);
var_dump($p->b);
```

You can get RGB, HSL, HSV, XYZ, hexadecimal string, CMYK (into futur I hope use it with [ICC profile](https://github.com/malenkiki/icc)…)

Complémentary color is easy:

```php
$p = new \Malenki\Palette('blue');
echo $p->complementary()->rgb();
```

Testing if color is one of the set of CSS colors and getting its name is done with the followings:

```php
$p = new \Malenki\Palette(255, 0, 0);

var_dump($p->isCss()); // should be true in this case
echo $p->cssName(); // should be 'red' here
```

Into string context, you get the HTML hexadecimal string:

```php
$p = new \Malenki\Palette('red');
echo $p; // should be '#FF0000'
```

Into near futur:
 - similar color
 - some other stuffs…
