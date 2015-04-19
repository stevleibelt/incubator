# Argument Handling for PHP CLI Scripts

* easy up handling of following kinds of arguments
    * lists (command --foobar="bar" --foobar="foo" | command -f"bar" -f"foo")
    * triggers (command -f|--force)
    * values values (command <value>)

# Example

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

# Why no Validation?

Validation is a complex topic. That's why I decided to not put it into the domain of this component.  
It would complicate the code itself. I would have created a universal validation interface that would slow down the usage of this component. Furthermore, you would have learn a validation expression language or would have need to write code that fits my validation interface.

At the end, what is validation all about?
* check if a argument (list, trigger, value) is passed or not
* if it is passed validate the value or if it is allowed under that circumstance (if it is right to use trigger "-f" while also trigger "-b" is passed etc.)
* if it is not passed but was mandatory, create a specific message or throw an exception (and the same for optional arguments)

To sum it up, validation is domain specific for the validation itself and the error handling. That's why I have decided to not support it deeply. The component supports your validation implementation with the methods "hasLists()", "hasList($name)" etc.

Since I won't write "never say never", if you have a smart idea or way to easy up validation, I'm open for an question or a pull request.

# Links (other good projects)

* [search on packagist](https://packagist.org/search/?search_query%5Bquery%5D=getopt)
* [yeriomin/getopt](https://github.com/yeriomin/getopt)
* [ulrichsg/getopt-php](https://github.com/ulrichsg/getopt-php)
* [stuartherbert/CommandLineLib](https://github.com/stuartherbert/CommandLineLib/)
* [auraphp/Aura.Cli](https://github.com/auraphp/Aura.Cli)
* [hoaproject/Console](https://github.com/hoaproject/Console)
* [deweller/php-cliopts](https://github.com/deweller/php-cliopts)
