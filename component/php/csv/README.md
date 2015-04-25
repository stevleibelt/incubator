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
//$headlines contains a php array
//$data contains a php array
$writer = new Writer('my/file.csv');

$writer->addHeadlines($headlines);

foreach ($data as $row) {
    $writer->addLine($row);
}
```

# At Once

```php
//$headlines contains a php array
//$data contains a php array
$writer = new Writer('my/file.csv');

$writer->addHeadlines($headlines);
$writer->addLines($data);
```

# Truncate

```php
$writer = new Writer('my/file.csv');

$writer->truncate();
```

# Other great component

* https://github.com/goodby/csv
* https://github.com/thephpleague/csv
* https://github.com/keboola/php-csv
* https://github.com/ajgarlag/AjglCsv
* https://github.com/jwage/easy-csv
* https://github.com/swt83/php-csv

# Developer Logbook And Thoughts

* writer
    * __invoke($data)   //write single line
    * ->writeOne($data);
    * ->writeMany(array $collection);
* reader
    * readOne();
    * readMany($limit);
    * readAll();
* factory
    * setDelimiter($this->getDelimiter()); //getters are protected to easy up extending
* version 2
    * setFilter(callable $filter);  //for readers and writers
    * writer
        * truncate();
        * copy($destination);
        * delete();
* version 3
    * wrapper/proxy to easy up migration from EasyCsv to this component
