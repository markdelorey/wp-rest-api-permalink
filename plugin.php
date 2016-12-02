<?php 
/*
Plugin Name: WP REST API Any Item
Version: 0.1 alpha
Description: Makes any post in the wp_posts table available by permalink or id regardless of post type.
Author: Mark Delorey
Author URI: http://www.markdelorey.com
*/



/*
function _rest_api_v2_exists() {
	return class_exists( 'WP_REST_Controller' );
}
*/


/**
 * Get an object from the wp_posts table by id or permalink
 * @return array - List of product objects
 */
function wp_api_v2_get_any_post ( $request ) {
	
	/*
	 *	TODO: sanitize the input a little better
	 */
	
	// determine if we have an id or a permalink
	if( !is_numeric($request['id']) ) {
		$request['id']	=	url_to_postid( $request['id'] );
	}
	
	/*
	 *	TODO: Look at how to determine how many results from the query and respond accordingly
	 */
	
	// response for nothing found
	if( !$request['id'] ) {
		return new WP_Error( 'id_not_found', 'No objects in wp_posts for id: '. $request['id'], array( 'status' => 404 ) );
	}
	
	// query for the object based on $id - will not return revisions or post types registered with exclude_from_search
	$q	=	new WP_Query(array( 
		'post_type' => 'any',
		'post__in'	=>	array( $request['id'] )
	));
	
	// should only find one object in wp_posts
	if( $q->post_count > 1 ) {
		return new WP_Error( 'multiple_ids_found', 'Multiple objects found in wp_posts for id: '. $request['id'], array( 'status' => 404 ) );
	}
	
	// prepare wp_post object for response
	if( $q->have_posts() ) {
		$q->the_post();
		
		$controller	=	new WP_REST_Posts_Controller( get_post_type() );
		
		return $controller->get_item( $request );
	}
	
	// catch other cases with an unknown error
	return new WP_Error( 'unknown_error', 'An unknown error occured in wp_api_v2_get_any_post while searching for '. $request['id']['id'], array( 'status' => 500 ) );
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/any-post', array(
        'methods' => 'GET',
        'callback' => 'wp_api_v2_get_any_post',
    ) );
} );
