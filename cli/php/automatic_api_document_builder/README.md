# Automatic Api Document Builder

# Idea

* iterating over collection of project paths
* searching for fitting configuration file
* generates documentation using apigen or someting similar
* creates index.html
* does a git pull and evaluates the output to check if there is work to do
* supporting multiple tags 

# Future Improvments

* add more documentation generators
* create factories
* add "keep_cache" (boolean) value
* impement cache and output cleanup (if project is moved or deleted etc.)

# Scribbled Thoughts

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

## dependencies

```
"net_bazzline/php_component_cli_arguments": "1.0.1"
"net_bazzline/component_requirement": "1.1.0"
"net_bazzline/php_component_command": "1.0.6"
"net_bazzline/php_component_process_pipe": "1.0.1"
```
