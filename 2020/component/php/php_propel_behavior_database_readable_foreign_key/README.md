# Database Readable Foreign Key Propel Behaviour for PHP

Alternative name "Cross Reference Behaviour".

This behaviour ease up the fetching of an object from another database table.

# Example

You have the following database.table.column layout.

```
my_database_one.my_table.id
my_database_two.other_table.my_table_id
```

And you want to have something like this in your entity (active record) class.

```php
$entity = new \MyDatabaseTwo\OtherTable();

$entity->setMyTableId(__LINE__);

//if it is a one_to_one_relation
$entity->getMyTable();  //returns either an object \MyDatabaseOne\MyTable or null

//if it is a one_to_namy_relation
$entity->getMyTables();  //returns either an propel object collection of \MyDatabaseOne\MyTable[] or null
```
