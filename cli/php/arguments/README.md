# Argument Handling for PHP CLI Scripts

* easy up handling of following kinds of arguments
    * lists (command --foobar="bar" --foobar="foo" | command -f"bar" -f"foo")
    * triggers (command -f|--force)
    * values values (command <value>)

# example

The call of following example.
```
php example.php --foo bar --foobar="foo" --foobar="bar" -f"foo" -f"bar" -b foobar foo
```

Generates the following output.
```
arguments provided:
    --foo
    bar
    --foobar=foo
    --foobar=bar
    -ffoo
    -fbar
    -b
    foobar
    foo
lists provided:
    foobar
        foo
        bar
    f
        foo
        bar
triggers provided:
    foo
    b
values provided:
    bar
    foobar
    foo
```

# Links (other good projects)

* [search on packagist](https://packagist.org/search/?search_query%5Bquery%5D=getopt)
* [yeriomin/getopt](https://github.com/yeriomin/getopt)
* [ulrichsg/getopt-php](https://github.com/ulrichsg/getopt-php)
* [stuartherbert/CommandLineLib](https://github.com/stuartherbert/CommandLineLib/)
* [auraphp/Aura.Cli](https://github.com/auraphp/Aura.Cli)
* [hoaproject/Console](https://github.com/hoaproject/Console)
* [deweller/php-cliopts](https://github.com/deweller/php-cliopts)
