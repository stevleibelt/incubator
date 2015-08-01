# API Token Authentication for ZF 2

* provides rest endpoint like "create-token-authentication" to get a valid token (via POST)
* provides rest endpoint like "delete-token-authentication" to invalidate token (via DELETE)
* token genertated by sha1sum(timestamp + salt + key)
* header field "Authorization"

# links

* http://www.django-rest-framework.org/api-guide/authentication/
* https://github.com/firebase/firebase-token-generator-php
* https://github.com/zfcampus/zf-oauth2
    * https://github.com/zfcampus/zf-oauth2/blob/master/src/Adapter/BcryptTrait.php
* https://de.wikipedia.org/wiki/HTTP-Authentifizierung
* https://en.wikipedia.org/wiki/List_of_HTTP_header_fields
* https://www.owasp.org/index.php/List_of_useful_HTTP_headers
* https://en.wikipedia.org/wiki/Representational_state_transfer
* https://github.com/RhubarbPHP/Scaffold.TokenBasedRestApi
* https://github.com/tappleby/laravel-auth-token
* https://github.com/unautreweb/symfony2-secured-rest-api
* https://github.com/jeins/basic-rest-api
* https://github.com/shahzada-saddam/yii2-rest-module
* https://github.com/messagebird/php-rest-api
* https://github.com/zfcampus/zf-mvc-auth
