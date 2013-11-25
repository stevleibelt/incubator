Static Page Generator
=====================

Tired of blog systems because they are for the web browser users?
Currently, i am. I don't want to blame the guys who are throwing there time on great open source projects to build a blog system with used by webbrowser. But thinking about myself, all i want is to write something in markdown or similar and upload this entry.

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
