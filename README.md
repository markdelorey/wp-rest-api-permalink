# WP REST API Permalink
Retrieve posts from wp_posts by permalink regardless of their post type. Helpful for single-page applications that still want to leverage permalinks and navigation menus.
## Requirements
* WP REST API plugin https://wordpress.org/plugins/rest-api/
## How to use
WP REST API Any Post adds one endpoint to the v2 rest api: /wp-json/wp/v2/permalink

The endpoint expects on URL parameter url which must be a permalink. The URL is used to look up post id using the url_to_postid() function (https://codex.wordpress.org/Function_Reference/url_to_postid). The request is then run through the WP_REST_Posts_Controller so that the post object returned is the same format you get from the WP REST API plugin and also because we can leverage all the security and filtering provided by the WP REST API plugin.
