Login Service
=============

Basic Concept
-------------

REST based web service to centralize login information.

The service holds login and passphrase information.
You current application askes the service by providing user login/passphrase combination and its api access key.

Storage Concept
---------------

login table

| id | login | hashed_passphrase |

application table

| id | key | url |
