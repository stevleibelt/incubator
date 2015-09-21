# Api Authorization Service

# REST Server Resources

* /authorize/<client id>/<hash of user name and user password>
    * Header: Authorize token: <client id>: <client token>
    * DELETE: removes authorization for given hash 
    * GET: returns status if is authorized or not and time of validity if is authorized
    * POST: creates new hash by provided <user name>, <user password> and <time of validity>
    * PUT: updates time of validity
* /login/<client id>
    * GET: returns a form

# Command Line Methods

* generate-api-key
* client-create <client name> <client token> <client callback url> <client form css resource url> : <string: client id>
* client-update <client id> [<client token>] [<client callback url>] [<client form css resource url>] : <bool>
* client-disable <client id>
* client-enable <client id>
* client-information <client id> : <array: client token, client callback client form css resource url, status> <

# Idea / Flow

* user wants to open an non public page of your application
* instead of opening a login form of your page, the login form will be loaded from the api authentication service
* if the login is successful, the api authentication service is calling your appilcation and sending a valid <identification hash>:<token>
* the user is now sending the <identification hash>:<token> in each request in the http header field
* you application can check the validity of this combination from time to time by using the resource described above
* if the user is opening important sections (like "my data", "payment" for e.g.), you should ask the user to authroize again)

# Terms

* "client token" is also known as "client secret"

# links

* [ApiGuard](https://github.com/FakeHeal/API-Guard)
* [phpHashAuth](https://github.com/PTKDev/OpenProtocol-phpHashAuth)
* [social-login](https://github.com/cresjie/social-login)
* [php-relmauth-service](https://github.com/fkooman/php-relmeauth-service)
* [SimpleOAuth](https://github.com/perecedero/SimpleOAuth)
* [RestApiSlim](https://github.com/barman789/rest_api_slim)
