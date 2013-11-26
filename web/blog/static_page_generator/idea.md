Static Page Generator
=====================

Tired of blog systems because they are for the web browser users?
Currently, i am. I do not want to blame the guys who are throwing there time on great open source projects to build a blog system with used by webbrowser. But thinking about myself, all i want is to write something in markdown or similar and upload this entry.

Core Functionalities
--------------------

* one template
* supports sections and subsections and subsections ...
* supports tags
* supports markdown
* a cronjob/or manually triggerd generation of parts possible (to fetch rss entries by other sites)
* a cronjob/or manually triggerd generation of articles
* cli generator
    * hook or event based for easy up extension 
    * generate file/entry/parts based content
    * generate all (reset of old content)
* rss and atom feed generation
* internal linking
* pure php array configuration

Nice To Have
------------

* rest api to simple
    * add an entry (generation done on the server)
    * add media
    * trigger cronjobs
* supports restructured text
* caching for converted markdown to html snippets
* meta data for each entry (default by section and tags)
* teaser for each entry
* search
* comments
* picture upload
* web generator

Currently Not Wanted
--------------------

* comments

Implementation
--------------

* each entry generats a unique identifier 
    * easy up human readable url renaming
    * easy up internal and external linking

Existing Projects
-----------------

* [hakyll](http://jaspervdj.be/hakyll)
* [Miblo](https://github.com/rafalp/Miblo)
* [bogl-me](https://github.com/turanct/bogl-me)
* [augustus](https://github.com/xles/augustus)
* [Astroid](https://github.com/cesarparent/Asteroid)
* [StaticBlogGenerator](https://github.com/genintho/StaticBlogGenerator)
* [acrylamid](https://github.com/posativ/acrylamid)
* [tempo](https://github.com/catnapgames/Tempo)

Components
----------

* rest web service to verifiy validity of id/passphrase combination (identity)
* cli component that implements general logic to communicate with upper rest service

Configurable Values
-------------------

* base url
* archive url
* section url
* tag url
* page title 
* default author
* entries per page per month

Workflow
--------

* write entry in my_file.md
    * contains
        * header
            * section
            * tag
            * [meta data]
            * [author]
        * body
            * content
* validate via cli
* upload file
* trigger page generation
    * convert markdown to html snippet
    * update tag page (if new exists, recalculate usage of tags)
    * update used tag pages (add link to entry, newest first)
    * update archive (current month section)
    * update main page

Structure Of Content
--------------------

* one main page of current month with link to previous[/next] month (link to archive)
* one section page of current month with link to previous[/next] month (link to archive)
* one tags page with link to each tag page, ordered by usage
* one tag page with links to each article, ordered by date
