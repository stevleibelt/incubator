# Automatic Api Document Builder

# Idea

* iterating over collection of project paths
* searching for fitting configuration file
* generates documentation using apigen or someting similar
* creates index.html
* does a git pull and evaluates the output to check if there is work to do
* supporting multiple tags 

# Scribble Section

## Configuration File

```php
return array(
    'generator' => 'apigen',
    'path' => array(
        'data' => 'path/to/store/data'
        'sources' => array(
            '/absolute/path/to/a/project',
            'relative/path/to/a/project'
        ),
        'target' => 'path/to/put/generated/content'
    ),
    'title' => 'code.bazzline.net'
);
```

## validating for changes

### code changes

```
git pull
# expected return
Already up-to-date.
```

### new releases

```
git tag -l
```
