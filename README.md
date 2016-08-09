# TL;DR

TL;DR is a base Wordpress theme developed by [Jonathan Kissam](http://jonathankissam.com)

## Features

### Shortcodes

__[html]__: this shortcode allows the insertion of arbitary html code, removing the extra `<p>` and `<br>` tags inserted by the wpautop filter.

__[post-summary]__: this shortcode essentially inserts an implementation of [WP_Query](https://codex.wordpress.org/Class_Reference/WP_Query). Any of the WP_Query [parameters](https://codex.wordpress.org/Class_Reference/WP_Query#Parameters) can be implemented as an attribute of the shortcode, except for the __fields__ paramater and the parameters which require associative arrays: __tax_query__, __date_query__, __meta_query__ and the __orderby__ associative array option.

The shortcode will display the post title (in `<h2 class="post-summary-title">`), if requested via custom attribute, the post thumbnail (in `<div class="post-summary-thumbnail">`), and the post content (in `<div class="post-summary-content">`). Each summary will be wrapped in a `<div class="post-summary">`.

Unless explicitly overridden, it will display all posts which meet the criteria, in descending date order - in other words, by default it will pass the following parameters to WP_Query:

`orderby => 'date'  
order => 'DESC'  
posts_per_page => -1`

The shortcode will also _exclude_ any posts which have previously been displayed on the page using the p attribute to load a single post (i.e., `[post-summary p="123"]`). This allows the display of one or more summaries at the top of an otherwise ordered list.

In addition, the shortcode offers several custom attributes:

* __n__: alias of posts_per_page
* __display_thumbnail__: passing any value which evaluates to true will include the post thumbnail, if one exists
* __post_thumbnail_size__: size for post thumbnail (defaults to 'post-thumbnail')
* __read_more__: text to be passed to get_the_content to be used as a read more link (defaults to "Read more")

## Development log

1.3: 8/9/2016 Added __[post-summary]__ shortcode 8/9/2016

1.2: 5/4/2016 Fixed error which was not loading scripts properly 

1.1: 1/25/2016 Added support for uploading and/or selecting a logo, using the Wordpress media uploader. 
