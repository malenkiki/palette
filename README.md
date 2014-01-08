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

You can get RGB, HSL, HSV, hexadecimal string, CMYK (into futur  hope with icc profile…)

Into near futur:
 - complementary color
 - similar color
 - some other stuffs…
