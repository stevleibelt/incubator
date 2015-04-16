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
lists provided:
    --foobar
        foo
        bar
    -f
        foo
        bar
triggers provided:
    --foo
    -b
values provided:
    bar
    foobar
    foo
```
