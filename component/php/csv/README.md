# CSV Handling Component for PHP

* heavily influenced by [jwage/easy-csv](https://github.com/jwage/easy-csv)
* only created because of missing compatibility with php 5.3 and no official packagist support

# Installation @todo

# Usage

## Read

```php
$reader = new Reader('my/file.csv');

if ($reader->hasHeadlines()) {
    echo 'headlines: ' . $reader->getHeadlines();
}

foreach ($reader as $row) {
    echo $row . PHP_EOL;
}
```

## Write

# By Iteration

```php
//$data contains a php array
$writer = new Writer('my/file.csv');

foreach ($data as $row) {
    $writer->addLine($row);
}
```

# At Once

```php
//$data contains a php array
$writer = new Writer('my/file.csv');

$writer->addLines($data);
```


# Other great component

* https://github.com/thephpleague/csv
* https://github.com/keboola/php-csv
* https://github.com/ajgarlag/AjglCsv
* https://github.com/jwage/easy-csv
* https://github.com/swt83/php-csv