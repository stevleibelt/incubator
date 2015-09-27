# Api Authorization Service

# REST Server Resources

* /authenticate/\<application_id>
    * DELETE: removes authorization for given hash 
    * GET: returns a form with css style from the client
    * POST: creates new hash by provided \<user name>, \<user password> [and \<time of validity>], returns http status, token and authentication session cookie
    * PUT: updates time of validity
* /check|test|review|verify/\<application_id>/\<token>
    * GET: returns http status and valid until as unix timestamp

# Command Line Methods

* generate-api-key
* client-create \<client name> \<client token> \<client redirect url> \<client form css resource url> : \<string: client id>
* client-update \<client id> [\<client token>] [\<client redirect url>] [\<client form css resource url>] : \<bool>
* client-disable \<client id>
* client-enable \<client id>
* client-information \<client id> : \<array: client token, client redirect client form css resource url, status>

# Database

## applications

* id: \<int|string>
* name: \<string>
* "callback_url": \<string>  # POST: \<your domain>/your/callback/url/    \<application_to_user.id>:\<token>
* "css_url|css_snippet": \<string>
* salt: \<string>
* is_active: \<bool|int>

## users

* id: \<int|string>
* name: \<string>
* email: \<string>
* password_hash: \<string>
* is_active: \<bool|int>

## application_to_user

* id: \<int|string>
* application_id: \<int|string>
* user_id: \<int|string>
* token: \<string>

# Idea / Flow

* user wants to open an non public page of your application
* instead of opening a login form of your page, the login form will be loaded from the api authentication service
* if the login is successful, the api authentication service is calling your appilcation and sending a valid \<identification hash>:\<token>
* the user is now sending the \<identification hash>:\<token> in each request in the http header field
* you application can check the validity of this combination from time to time by using the resource described above
* if the user is opening important sections (like "my data", "payment" for e.g.), you should check the validity of the token immediately and ask the user to authroize again if necessary)
* if user has session cookie from authentication service, there is no need to provide credentials again

# Terms

* "client token" is also known as "client secret"

# Links

* [ApiGuard](https://github.com/FakeHeal/API-Guard)
* [phpHashAuth](https://github.com/PTKDev/OpenProtocol-phpHashAuth)
* [social-login](https://github.com/cresjie/social-login)
* [php-relmauth-service](https://github.com/fkooman/php-relmeauth-service)
* [SimpleOAuth](https://github.com/perecedero/SimpleOAuth)
* [RestApiSlim](https://github.com/barman789/rest_api_slim)
* [oauth](http://oauth.net/)
* [beginners guide to oauth](http://hueniverse.com/2007/10/04/beginners-guide-to-oauth-part-i-overview/)
* [autorisierungsdienst mit oauth](http://www.heise.de/developer/artikel/Autorisierungsdienste-mit-OAuth-845382.html)
* [api-autorisierung-mit-oauth](http://www.pc-magazin.de/ratgeber/api-autorisierung-mit-oauth-2-1335680.html)

# History

* upcoming
    * @todo
        * implement cqrs
        * implement rights per application (including more data per user)
        * block if ip x is trying to often to login
        * update your password
        * support multiple return formats (xml beside json)
