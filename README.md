HaircuttersCalculator
=====================

#### PHP class ####

Depends on paramaters like population of country HaircuttersCalculator will calculate approximate number of haircutters needed in this country.


### Usage ###

Download the [ZIP archive](https://github.com/aptik/HaircuttersCalculator/archive/master.zip) extract and include it in your program.

```php
include 'path/to/class/Calculator.php';
```

Create an object and run `calculate()` method:

```php
$HC = new HaircuttersCalculator\Calculator();
echo $HC->calculate();
```
If everything went well you should see an approximate number of haircutters (**176,201**) needed with default parameters:

* Population: **50000000**
* Mans rate: **54.0**
* Time needed to shear man: **30**
* Time needed to shear woman: **60**
* How often the person shorn during the year: **12**
* Haircutters working days (in the year): **345.25**
* Haircutters working minutes per day: **432**

You can set/change parameters in few ways:

```php
// pass it on object creation
$HC = new HaircuttersCalculator\Calculator(50000,20);
```
```php
// or even as array:
$HC = new HaircuttersCalculator\Calculator(array('population'=>20000));
```
```php
// using setParameter() method:
$HC = new Calculator();
$HC->setParameter('population',50000001);
```
```php
// using setParameter() method with array as argument:
$HC = new Calculator();
$HC->setParameter(array(
  'man_rate'=>54,
  'haircutters_working_days'=>10
));
```

### Web UI ###

You can check working copy visiting next URL:

[http://haircutters-calculator-webui.gopagoda.com](http://haircutters-calculator-webui.gopagoda.com)

Or you can host files provided in [ZIP archive](https://github.com/aptik/HaircuttersCalculator/archive/master.zip) and access `index.php`.

### CLI ###

Also I provide an sample of CLI usage in file [cli.php](cli.php):

```bash
$: chmod +x cli.php
$: ./cli.php --population=20000

Input data:
Array
(
    [population] => 20000
    [man_rate] => 54
    [shear_time_man] => 30
    [shear_time_woman] => 60
    [shears_per_year] => 12
    [haircutters_working_days] => 345.25
    [haircutters_working_minutes] => 432
)
Result: 71 haircutters needed.
```

You can pass `--help` parameter to it to get some help:
```bash
$: ./cli.php --help

Usage:
./cli.php [--paramater1=value1 [--parameter2=value2 ... [--parameterN=valueN]]]
Allowed paramaters:
    --population=integer                  Default 50000000
    --man_rate=double                     Default 54
    --shear_time_man=integer              Default 30
    --shear_time_woman=integer            Default 60
    --shears_per_year=integer             Default 12
    --haircutters_working_days=double     Default 345.25
    --haircutters_working_minutes=integer Default 432
```

### Tests ###

To run tests you need to use next [PHPUnit](http://phpunit.de/) command:

```bash
phpunit --bootstrap tests/BootstrapLoader.php tests/HaircuttersCalculator/CalculatorTest.php
```

If everithing went well there must be output like:

```
OK (12 tests, 23 assertions)
```

### Documentation ###

You can read documentation of HaircuttersCalculator generated by [phpDocumentor](http://www.phpdoc.org/) using this [link](https://rawgithub.com/aptik/HaircuttersCalculator/master/docs/classes/HaircuttersCalculator.Calculator.html).

### License ###

![by-nc-nd](http://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png "Creative Commons License")

HaircuttersCalculator by [Arthur Halma](https://github.com/aptik/)  is licensed under a [Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License](http://creativecommons.org/licenses/by-nc-nd/4.0/).

Based on a work at [https://github.com/aptik/HaircuttersCalculator](https://github.com/aptik/HaircuttersCalculator).