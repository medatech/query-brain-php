query-brain-php
===============

PHP Client for http://querybrain.com

Installation
------------

Add the `lib` folder to your project.  Include lib/querybrain.php to use.

Usage
-----

### Get Schema

```php
$apiKey = '1234567890';
$queryBrain = new QueryBrain($apiKey);
$schema = $queryBrain->getSchema();
print_r($schema);
```

**Output**

```
Array
(
    [id] => string
    [cat] => string[]
    [name] => string
    [manu] => string
    [megapixel] => float
    [minISO] => int
    [maxISO] => int
    [video] => boolean
    [videoMaxHor] => int
    [videoMaxVer] => int
    [itemWeight] => int
    [modelNumber] => string
    [price] => float
    [text] => string
)
```