<?php

/**
 * Registers the `book_tag` taxonomy,
 * for use with 'book'.
 */
function book_tag_init() {
	register_taxonomy( 'book_tag', 'book', [
		'hierarchical'          => false,
		'public'                => true,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => true,
		'capabilities'          => [
			'manage_terms' => 'edit_posts',
			'edit_terms'   => 'edit_posts',
			'delete_terms' => 'edit_posts',
			'assign_terms' => 'edit_posts',
		],
		'labels'                => [
				'name'                       => __( 'Book Tags', 'book-library' ),
				'singular_name'              => _x( 'Book Tag', 'taxonomy general name', 'book-library' ),
				'search_items'               => __( 'Search Book Tags', 'book-library' ),
				'popular_items'              => __( 'Popular Book Tags', 'book-library' ),
				'all_items'                  => __( 'All Book Tags', 'book-library' ),
				'edit_item'                  => __( 'Edit Book Tag', 'book-library' ),
				'update_item'                => __( 'Update Book Tag', 'book-library' ),
				'add_new_item'               => __( 'Add New Book Tag', 'book-library' ),
				'new_item_name'              => __( 'New Book Tag', 'book-library' ),
				'separate_items_with_commas' => __( 'Separate book tags with commas', 'book-library' ),
				'add_or_remove_items'        => __( 'Add or remove book tags', 'book-library' ),
				'choose_from_most_used'      => __( 'Choose from the most used book tags', 'book-library' ),
				'not_found'                  => __( 'No book tags found.', 'book-library' ),
				'no_terms'                   => __( 'No book tags', 'book-library' ),
				'menu_name'                  => __( 'Book Tags', 'book-library' ),
				'items_list_navigation'      => __( 'Book Tags list navigation', 'book-library' ),
				'items_list'                 => __( 'Book Tags list', 'book-library' ),
				'most_used'                  => _x( 'Most Used', 'book_tag', 'book-library' ),
				'back_to_items'              => __( '&larr; Back to Book Tags', 'book-library' ),
		],
		'show_in_rest'          => true,
		'rest_base'             => 'book_tag',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	] );
}

add_action( 'init', 'book_tag_init' );

/**
 * Sets the post updated messages for the `book_tag` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `book_tag` taxonomy.
 */
function book_tag_updated_messages( $messages ) {

	$messages['book_tag'] = [
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Book Tag added.', 'book-library' ),
		2 => __( 'Book Tag deleted.', 'book-library' ),
		3 => __( 'Book Tag updated.', 'book-library' ),
		4 => __( 'Book Tag not added.', 'book-library' ),
		5 => __( 'Book Tag not updated.', 'book-library' ),
		6 => __( 'Book Tags deleted.', 'book-library' ),
	];

	return $messages;
}

add_filter( 'term_updated_messages', 'book_tag_updated_messages' );