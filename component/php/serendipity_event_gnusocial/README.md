# serendipity event plugin to push new entry headline into your gnu social stream

* api documentation is shitty or not existing
* only headline and link is pushed
* only tested with [gnusocial.de](https://gnusocial.de)
* no error handling (error code >= 400, endpoint not available)
* [gnusocial.de api](https://gnusocial.de/api/statusnet/config.xml)
* [gnu social source code](https://git.gnu.io/gnu/gnu-social)

# todos

* use [really simple discovery](https://en.wikipedia.org/wiki/Really_Simple_Discovery) for api discovery
* use HTTP_Request
* implement error handling (see [facebook](https://github.com/s9y/additional_plugins/blob/master/serendipity_event_facebook/serendipity_event_facebook.php) plugin)
* implement url shortener
* implement correct way of building the full qualified link

# links

* [gnusrss.py](https://daemons.cf/cgit/gnusrss/tree/gnusrss.py)
* [identi/identica](https://github.com/psibi/Identier/blob/master/identi/identica_mappings.py)