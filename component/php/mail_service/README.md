# Mail Service

The component will centralize and easy up sending of emails.

# Main Idea

A microservice which publish an api to validate and send on or multiple emails.
Furthermore, archiving, statistical numbers and speed optimization is a core functionality.
The used mail library should be layerd by a generic interface design. Either search for an upcomming PSR, create one or start by looking at [this](https://github.com/stevleibelt/php_send_email_via_command_line/tree/master/source).

# Api

* /enqueue-mail
    * PUT - adds mail to the queue
* /enqueue-mails
    * PUT - adds collection of mails to the queue
* /mail/<id>
    * DELETE - removes mail
    * GET - returns status
* /validate-mail
    * PUT - validates an email address

# Unordered Ideas

* wheneever you add something, you need to get back a unique id
* if you call an endpoint with that id, you get back a status (success|error)
* if needed and allowed
    * 24 tables will be created at 23:00 in the format "yyyy_mm_dd_hh_00_00"
