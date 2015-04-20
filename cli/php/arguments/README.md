# Argument Handling for PHP CLI Scripts

# Why?

* easy up handling of following kinds of arguments
    * flags (command -f|--force)
    * lists (command --foobar"bar" --foobar=foo | command -f"bar" -f=foo)
    * values values (command <value>)

# Example

The call of following example.
```
php example.php --foo bar --foobar=foo --foobar="bar" -f"foo" -f=bar -b foobar foo
```

Generates the following output.
```
arguments provided:
    --foo
    bar
    --foobar=foo
    --foobar=bar
    -ffoo
    -f=bar
    -b
    foobar
    foo
flags provided:
    foo
    b
lists provided:
    foobar
        foo
        bar
    f
        foo
        bar
values provided:
    bar
    foobar
    foo
```

# Terms

All arguments are grouped into one of three types, flags, lists or values.

## Flag

A flag is an argument that changes the behaviour of an command. It acts as a trigger so you can turn things on or off (best example in the world "-h|--help")

The position in a commandcall for a flag is not important, only the existence.

## List

A list is an argument that contains multiple values per name.

This call
```
php example.php --my_list="argument one" --my_list="argument two"
```
would result into a list with the name "my_list" and two arguments, "argument one" and "argument two".

Lists are the most complex arguments. Like for flags, the position in a commandcall for a list usage is not important.

## Value

Values are straight forward arguments. You simple pass them to your command. Instead of a flag or a list, the position is important.

```
php example.php "value one" "value two"
```

First value has the content "value one", second value has the content "value two".

```
php example.php "value two" "value one"
```

First value has the content "value two", second value has the content "value one".


# Why no Validation?

Validation is a complex topic. That's why I decided to not put it into the domain of this component.  
It would complicate the code itself. I would have created a universal validation interface that would slow down the usage of this component. Furthermore, you would have learn a validation expression language or would have need to write code that fits my validation interface.

At the end, what is validation all about?
* check if a argument (flag, list, value) is passed or not
* if it is passed validate the value or if it is allowed under that circumstance (if it is right to use flag "-f" while also flag "-b" is passed etc.)
* if it is not passed but was mandatory, create a specific message or throw an exception (and the same for optional arguments)

To sum it up, validation is domain specific for the validation itself and the error handling. That's why I have decided to not support it deeply. The component supports your validation implementation with the methods "hasLists()", "hasList($name)" etc.

Since I won't write "never say never", if you have a smart idea or way to easy up validation, I'm open for an question or a pull request.

# What about Optional Values?

Optional values underlying the same problems as validation does, not domain specific, not that easy to implement elegant and especially very special (e.g. value is optional if flag "--xyz" is used, otherwise mandatory).
All about, your code has to take care if a argument is passed or not anyways, so using the available "has..."-methods should be sufficient and generic enough.

# Links (other good projects)

* [search on packagist](https://packagist.org/search/?search_query%5Bquery%5D=getopt)
* [yeriomin/getopt](https://github.com/yeriomin/getopt)
* [ulrichsg/getopt-php](https://github.com/ulrichsg/getopt-php)
* [stuartherbert/CommandLineLib](https://github.com/stuartherbert/CommandLineLib/)
* [auraphp/Aura.Cli](https://github.com/auraphp/Aura.Cli)
* [hoaproject/Console](https://github.com/hoaproject/Console)
* [deweller/php-cliopts](https://github.com/deweller/php-cliopts)
