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
    foobar=f
        foo
    foobar=b
        bar
    ff
        foo
    fb
        bar
triggers provided:
    foo
    b
values provided:
    bar
    foobar
    foo
```
