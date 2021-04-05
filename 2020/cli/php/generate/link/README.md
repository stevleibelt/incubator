# Link Page Generator

## Database

* name is 'link'

## table links

* id
* name
* title
* url

## table categories

* id
* name

## table categorie_structure

* id
* categorie_id
* parent_categorie_id

## table tags

* id
* name

## table link_to_tag

* id
* link_id
* tag_id

## table link_to_categorie

* id
* categorie_id
* link_id

## sql

```sql
CREATE DATABASE `net_bazzline_link_builder` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE DATABASE `net_bazzline_link_builder`;

CREATE TABLE `links`
(
    `id` CHAR (32) NOT NULL,
    `name` VARCHAR (255) NOT NULL,
    `title` VARCHAR (255) NOT NULL,
    `url` VARCHAR (255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `` (`id`)
) Engine=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE `categories`
(
    `id` CHAR (32) NOT NULL,
    `name` VARCHAR (255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `id` (`id`)
) Engine=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE `categorie_structure`
(
    `id` CHAR (32) NOT NULL,
    `categorie_id` char (32) NOT NULL,
    `parent_categorie_id` char (32) DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `id` (`id`),
    INDEX `id` (`categorie_id`),
    INDEX `id` (`parent_categorie_id`)
) Engine=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tags`
(
    `id` CHAR (32) NOT NULL,
    `name` VARCHAR (255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `id` (`id`)
) Engine=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE `link_to_tag`
(
    `id` CHAR (32) NOT NULL,
    `link_id` char (32) NOT NULL,
    `tag_id` char (32) NOT NULL,
    FOREIGN KEY (`link_id`) REFERENCES `links` (`id`),
    FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) Engine=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE `link_to_categorie`
(
    `id` CHAR (32) NOT NULL,
    `categorie_id` char (32) NOT NULL,
    `link_id` char (32) NOT NULL,
    FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`),
    FOREIGN KEY (`link_id`) REFERENCES `links` (`id`)
) Engine=InnoDB DEFAULT CHARSET=utf8; 
```
