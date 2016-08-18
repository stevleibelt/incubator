# (yet another) PHP static blog system

Well, this is starting as a php rebuild of the [bashblog](https://github.com/cfenollosa/bashblog).

# Structure

## Configuration

* software
    * name
    * version
* blog
    * title
    * description
    * url
    * author
        * name
        [* url]
        [* email]
    * license
    * web analytic provider (piwik, google analytics etc.)
        * path to the file snippet
    * web feed management provider (feedburner etc.)
    * comment provider (twitter, disqus, discourse etc.)
    * index
        * number of articles on the index page
        * file name (like "index.html")
    * archive
        * relative path (like "archive")
        * file name (like "index.html")
    * tag
        * relative path (like "tag")
        * file name (like "index.html")
    * feed
        * number of articles in the feed
        * file name (like "rss.xml")
    * entry
        * unique identifier generator (autoincrement, uuid, date based etc)
        * path to the entries
        * prefix for unpublished entries
        * keep deleted entries (if so, simple prefix them with deleted)
    * design
        * path to the content file
        * path to the entry file
        * path to the header file
        * path to the footer file
    * translation
        * link title for the comments 
        * link title for read more ...
        * link title for view more posts
        * link title for all posts
        * link title for all tags
        * link title for back to the index
        * link title for subscribe
        * header line for the tags (like "Tags:")
    * date format
    * external dependencies
        * path to the markdown binary (like /usr/bin/markdown)
        * path to the editor (like /usr/bin/vim)
 
## Workflow

* validate configuration
* test markdown ("line 1\n\nline 2" == "<p>line 1</p>\n\n<p>line 2</p>"
* update entries cataloge to get new or changed markdown files
* parse new or changed markdown files into html
    * add the comment section if needed
* update index page
* update archive pages
* update tage page
* update feed manatement if needed

## Commands

* edit entry <file name>
* create entry <file name>
* list entries
* delete entry <file name>
* delete all entries
* publish entry <file name>
* publish all entries

## Thoughts

* wrapp content, headline and tag parts of an entry with comments like "<!-- begin of content section -->/<!-- end of content seciont -->" to ease up cutting and updating
* do not complicate things, take a look to the smart way how cfenolloasa solves problem (like rss feed generation :-))
* add a watcher to a git repository to pull each x minutes and publish all entries (even new one from the repository)
