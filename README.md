# WP REST API Any Post
Retrieve posts from wp_posts by slug or id regardless of their post type. Helpful for single-page applications that still want to leverage permalinks and navigation menus.
## Requirements
* WP REST API plugin https://wordpress.org/plugins/rest-api/
## How to use
WP REST API Any Post adds one endpoint to the v2 rest api: /wp-json/wp/v2/any-post

The endpoint expects on URL parameter id which can either be an integer for the numeric id in the wp_posts table or a permalink. If you send a permalink, it will be changed to the post numeric id using the url_to_postid() function (https://codex.wordpress.org/Function_Reference/url_to_postid). The request is then run through the WP_REST_Posts_Controller so that the post object returned is the same format you get from the WP REST API plugin and also because we can leverage all the security and filtering provided by the WP REST API plugin.
