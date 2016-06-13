# Mail Service

The component will centralize and easy up sending of emails.

# Main Idea

A microservice which publish an api to validate and send on or multiple emails.
Furthermore, archiving, statistical numbers and speed optimization is a core functionality.
The used mail library should be layerd by a generic interface design. Either search for an upcomming PSR, create one or start by looking at [this](https://github.com/stevleibelt/php_send_email_via_command_line/tree/master/source).

# Api

* /enqueue-email
    * PUT - adds mail to the queue
* /enqueue-emails
    * PUT - adds collection of mails to the queue
* /email/<id>
    * DELETE - removes mail
    * GET - returns collection of available mails with their status, ?filterById and filterByStatus could be supported
* /validate-email-address
    * PUT - validates an email address

# What is a Mail?

* collection of objects

## As JSON

```javascript
{
    "attachments": {
        //@todo
    },
    "blind_carbon_copy": {
        {
            "address": "<address>",
            "name": "<name>"
        }
    },
    "carbon_copy": {
        {
            "address": "<address>",
            "name": "<name>"
        }
    },
    "content": {
        "html": "<html>",
        "text": "<text>",
    },
    "error_to": {
        "address": "<address>",
        "name": "<name>"
    },
    "from": {
        "address": "<address>",
        "name": "<name>"
    },
    "reply_to": {
        "address": "<address>",
        "name": "<name>"
    },
    "subject": "<subject>",
    "to": {
        "address": "<address>",
        "name": "<name>"
    }
}
```

## As PHP Class

```php
class Mail
{
    /** @var Attachment[] */
    private $attachments;

    /** @var Address[] */
    private $blindCarbonCopies;

    /** @var Address[] */
    private $carbonCopies;

    /** @var Content */
    private $content;

    /** @var Address */
    private $errorTo;

    /** @var Address */
    private $from;

    /** @var Address */
    private $replyTo;

    /** @var Subject */
    private $subject;

    /** @var Address */
    private $to;
}
```

# Unordered Ideas

* wheneever you add something, you need to get back a unique id
* if you call an endpoint with that id, you get back a status (success|error)
* if needed and allowed
    * 24 tables will be created at 23:00 in the format "yyyy_mm_dd_hh_00_00"
* use [this](https://github.com/stevleibelt/php_send_email_via_command_line/tree/master/source/DomainModel) domain models as start
* support multiple shippers
* create serializer and deserlializer for a mail (Abstract, JSON, XML)
* add reactphp or [ppm](https://github.com/marcj/php-pm)
* add support for redis or something else to speed up database access

# Roadmap

* 0.1.0     - able to ship a mail, support enqueue-mail api with a json string
* 0.2.0     - secure the api with an api token
* 0.3.0     - support enqueue-mails
* 0.4.0     - support separate configuration option
* 0.5.0     - add installation option for easy and quick setup via cli
* 0.6.0     - move shipper and mail into separate repositories (as well as abstract versions for it)
* 0.7.0     - enhance configuration option by choosing and adding the supported shippers to the configuration
* 0.8.0     - add database storage and move away from instant mail sending
* 0.9.0     - add api /mail
* 0.10.0    - add api /validate-email-address
* 1.0.0     - fix bugs
* 1.1.0     - refactore
