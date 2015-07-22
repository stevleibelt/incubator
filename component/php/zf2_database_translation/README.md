# Database Based Translation For Zend Framework 2

* based on [my thougts](https://artodeto.bazzline.net/archives/814-zend-framework-2-translation-on-steroids-some-thoughts.html)
* replace existing translation view helper with an databased one
* add a sql script to setup the database
* add a command line to copy the existing translations into the database
* add an administration form to update the translations
* add configuration section to use redis as caching

# example configuration

```php

return array(
    'zf2_database_translation' => array(
        'translation_key_not_found_prefix' => '...',
        'database' => array(
            'name'                              => 'translation',
            'table_name_for_the_keys'           => 'keys'
            'table_name_prefix_for_the_values'  => 'language_'
        ),
        'redis' => array(
            'is_enabled'    => true,
            'database'      => 'translation',
            'host'          => 'localhost',
            'password'      => 123,
            'port'          => 6379
        )
    )
);
```
