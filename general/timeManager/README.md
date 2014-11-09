# Time Manager

# General

* authentication token as to provided on each request (except routes "/login" and "/register")
* only self ownd time entries can be changed and deleted

# (REST) API Structure

| url       | method    | parameters                                        | description                   |
|-----------|-----------|---------------------------------------------------|-------------------------------|
|/register  | POST      | email, password                                   | creates new account           |
|/login     | POST      | email, password                                   | creates authentication token  |
|/entrys    | GET       | [start=Y-m-d%20H:i:s][end=Y-m-d%20H:i:s]          | fetches all entries           |
|/entry     | POST      | start, end, subject, content, tags                | create entry                  |
|/entry/:id | GET       |                                                   | fetch single entry            |
|/entry/:id | PUT       | start, end, subject, content, tags                | update entry                  |
|/entry/:id | DELETE    |                                                   | delete entry                  |
|/tags      | GET       | [prefix=character[character[...]]]                | fetch all tags                |
|/tag       | POST      | name                                              | create tag                    |
|/tag/:id   | GET       |                                                   | fetch single tag              |
|/tag/:id   | PUT       | name                                              | update tag                    |
|/tag/:id   | DELETE    |                                                   | delete tag                    |

# Database Tables

## user_login

* id
* email (hashed)
* password (hashed)

## user_authentication_token

* id
* user_id
* authentication_token
* valid_until

## user

* id
* user_login_id
* created_at

## entry

* id
* created_at
* started_at
* finished_at
* subject
* content

## user_to_entry

* id
* user_id
* entry_id

# links 

* http://www.androidhive.info/2014/01/how-to-create-rest-api-for-android-app-using-php-slim-and-mysql-day-12-2/
