<?php

/**
 * Registers the `book_category` taxonomy,
 * for use with 'book'.
 */
function book_category_init() {
	register_taxonomy( 'book_category', 'book', [
		'hierarchical'          => true,
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
			'name'                       => __( 'Book Categories', 'book-library' ),
			'singular_name'              => _x( 'Book Category', 'taxonomy general name', 'book-library' ),
			'search_items'               => __( 'Search Book Categories', 'book-library' ),
			'popular_items'              => __( 'Popular Book Categories', 'book-library' ),
			'all_items'                  => __( 'All Book Categories', 'book-library' ),
			'parent_item'                => __( 'Parent Book Category', 'book-library' ),
			'parent_item_colon'          => __( 'Parent Book Category:', 'book-library' ),
			'edit_item'                  => __( 'Edit Book Category', 'book-library' ),
			'update_item'                => __( 'Update Book Category', 'book-library' ),
			'view_item'                  => __( 'View Book Category', 'book-library' ),
			'add_new_item'               => __( 'Add New Book Category', 'book-library' ),
			'new_item_name'              => __( 'New Book Category', 'book-library' ),
			'separate_items_with_commas' => __( 'Separate book categories with commas', 'book-library' ),
			'add_or_remove_items'        => __( 'Add or remove book categories', 'book-library' ),
			'choose_from_most_used'      => __( 'Choose from the most used book categories', 'book-library' ),
			'not_found'                  => __( 'No book categories found.', 'book-library' ),
			'no_terms'                   => __( 'No book categories', 'book-library' ),
			'menu_name'                  => __( 'Book Categories', 'book-library' ),
			'items_list_navigation'      => __( 'Book Categories list navigation', 'book-library' ),
			'items_list'                 => __( 'Book Categories list', 'book-library' ),
			'most_used'                  => _x( 'Most Used', 'book_category', 'book-library' ),
			'back_to_items'              => __( '&larr; Back to Book Categories', 'book-library' ),
		],
		'show_in_rest'          => true,
		'rest_base'             => 'book_category',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	] );
}

add_action( 'init', 'book_category_init' );

/**
 * Sets the post updated messages for the `book_category` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `book_category` taxonomy.
 */
function book_category_updated_messages( $messages ) {

	$messages['book_category'] = [
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Book Category added.', 'book-library' ),
		2 => __( 'Book Category deleted.', 'book-library' ),
		3 => __( 'Book Category updated.', 'book-library' ),
		4 => __( 'Book Category not added.', 'book-library' ),
		5 => __( 'Book Category not updated.', 'book-library' ),
		6 => __( 'Book Categories deleted.', 'book-library' ),
	];

	return $messages;
}

add_filter( 'term_updated_messages', 'book_category_updated_messages' );
