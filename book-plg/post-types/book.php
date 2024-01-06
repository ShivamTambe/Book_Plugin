<?php

/**
 * Registers the `book` post type.
 */

function book_init() {
	register_post_type(
		'book',
		[
			'labels'                => [
				'name'                  => __( 'Books', 'book-library' ),
				'singular_name'         => __( 'Book', 'book-library' ),
				'all_items'             => __( 'All Books', 'book-library' ),
				'archives'              => __( 'Book Archives', 'book-library' ),
				'attributes'            => __( 'Book Attributes', 'book-library' ),
				'insert_into_item'      => __( 'Insert into Book', 'book-library' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Book', 'book-library' ),
				'featured_image'        => _x( 'Book Cover', 'book', 'book-library' ),
				'set_featured_image'    => _x( 'Set Book Cover', 'book', 'book-library' ),
				'remove_featured_image' => _x( 'Remove Book Cover', 'book', 'book-library' ),
				'use_featured_image'    => _x( 'Use as Book Cover', 'book', 'book-library' ),
				'filter_items_list'     => __( 'Filter Books list', 'book-library' ),
				'items_list_navigation' => __( 'Books list navigation', 'book-library' ),
				'items_list'            => __( 'Books list', 'book-library' ),
				'new_item'              => __( 'New Book', 'book-library' ),
				'add_new'               => __( 'Add New', 'book-library' ),
				'add_new_item'          => __( 'Add New Book', 'book-library' ),
				'edit_item'             => __( 'Edit Book', 'book-library' ),
				'view_item'             => __( 'View Book', 'book-library' ),
				'view_items'            => __( 'View Books', 'book-library' ),
				'search_items'          => __( 'Search Books', 'book-library' ),
				'not_found'             => __( 'No Books found', 'book-library' ),
				'not_found_in_trash'    => __( 'No Books found in trash', 'book-library' ),
				'parent_item_colon'     => __( 'Parent Book:', 'book-library' ),
				'menu_name'             => __( 'Books', 'book-library' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revision' ],
			'has_archive'           => 'books',
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-book-alt',
			'show_in_rest'          => true,
			'rest_base'             => 'book',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);
}

add_action( 'init', 'book_init' );

/**
 * Sets the post updated messages for the `book` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `book` post type.
 */
function book_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['book'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Book updated. <a target="_blank" href="%s">View Book</a>', 'book-library' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'book-library' ),
		3  => __( 'Custom field deleted.', 'book-library' ),
		4  => __( 'Book updated.', 'book-library' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Book restored to revision from %s', 'book-library' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Book published. <a href="%s">View Book</a>', 'book-library' ), esc_url( $permalink ) ),
		7  => __( 'Book saved.', 'book-library' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Book submitted. <a target="_blank" href="%s">Preview Book</a>', 'book-library' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Book</a>', 'book-library' ), date_i18n( __( 'M j, Y @ G:i', 'book-library' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Book draft updated. <a target="_blank" href="%s">Preview Book</a>', 'book-library' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'book_updated_messages' );

/**
 * Sets the bulk post updated messages for the `book` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `book` post type.
 */
function book_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['book'] = [
		/* translators: %s: Number of Books. */
		'updated'   => _n( '%s Book updated.', '%s Books updated.', $bulk_counts['updated'], 'book-library' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Book not updated, somebody is editing it.', 'book-library' ) :
						/* translators: %s: Number of Books. */
						_n( '%s Book not updated, somebody is editing it.', '%s Books not updated, somebody is editing them.', $bulk_counts['locked'], 'book-library' ),
		/* translators: %s: Number of Books. */
		'deleted'   => _n( '%s Book permanently deleted.', '%s Books permanently deleted.', $bulk_counts['deleted'], 'book-library' ),
		/* translators: %s: Number of Books. */
		'trashed'   => _n( '%s Book moved to the Trash.', '%s Books moved to the Trash.', $bulk_counts['trashed'], 'book-library' ),
		/* translators: %s: Number of Books. */
		'untrashed' => _n( '%s Book restored from the Trash.', '%s Books restored from the Trash.', $bulk_counts['untrashed'], 'book-library' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'book_bulk_updated_messages', 10, 2 );


// Add meta box for Book Information
function book_meta_box() {
    add_meta_box(
        'book_meta_box',          // Unique ID
        'Book Information',       // Box title
        'display_book_meta_box',  // Callback function to display the box content
        'book',                   // Post type
        'normal',                 // Context
        'high'                    // Priority
    );
}
add_action('add_meta_boxes', 'book_meta_box');

// Callback function to display meta box content
function display_book_meta_box($post) {
    // Retrieve current values from the database
    /*$author_name = get_post_meta($post->ID, 'book_author_name', true);
    $price = get_post_meta($post->ID, 'book_price', true);
    $publisher = get_post_meta($post->ID, 'book_publisher', true);
    $year = get_post_meta($post->ID, 'book_year', true);
    $edition = get_post_meta($post->ID, 'book_edition', true);
    $url = get_post_meta($post->ID, 'book_url', true);
	*/

	global $wpdb;
	$author_name = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s", $post->ID, 'book_author_name'));
	$price = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s", $post->ID, 'book_price'));
	$publisher = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s", $post->ID, 'book_publisher'));
	$year = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s", $post->ID, 'book_year'));
	$edition = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s", $post->ID, 'book_edition'));
	$url = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s", $post->ID, 'book_url'));

	// error_log('Author Name: ' . print_r($author_name, true) .  ' Dahi');
    // error_log('POST ID: ' . print_r($post->ID, true) .  ' Post');
    // HTML for the fields
    ?>
    <label for="author_name">Author Name:</label>
    <input type="text" name="author_name" value="<?php echo esc_attr($author_name); ?>" />

    <label for="price">Price:</label>
    <input type="text" name="price" value="<?php echo esc_attr($price); ?>" />

    <label for="publisher">Publisher:</label>
    <input type="text" name="publisher" value="<?php echo esc_attr($publisher); ?>" />

    <label for="year">Year:</label>
    <input type="text" name="year" value="<?php echo esc_attr($year); ?>" />

    <label for="edition">Edition:</label>
    <input type="text" name="edition" value="<?php echo esc_attr($edition); ?>" />

    <label for="url">URL:</label>
    <input type="text" name="url" value="<?php echo esc_attr($url); ?>" />
    <?php
}

add_filter('rwmb_meta_tables', function ($tables) {
    $tables['book'] = 'wp_book_meta';
    return $tables;
});


// Save meta box data
function save_book_meta_data($post_id) {
    // Check if the current user is authorized to do this action
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    global $wpdb;

    $fields = ['author_name', 'price', 'publisher', 'year', 'edition', 'url'];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $field_value = sanitize_text_field($_POST[$field]);

            // Assuming your custom table is named 'wp_book_meta'
            $table_name = $wpdb->prefix . 'book_meta';

            // Check if a record already exists for this post and field
            $existing_record = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM $table_name WHERE book_id = %d AND meta_key = %s",
                    $post_id,
                    'book_' . $field
                )
            );

            if ($existing_record) {
                // Update the existing record
                $wpdb->update(
                    $table_name,
                    ['meta_value' => $field_value],
                    ['book_id' => $post_id, 'meta_key' => 'book_' . $field],
                    ['%s'],
                    ['%d', '%s']
                );
            } else {
                // Insert a new record
                $wpdb->insert(
                    $table_name,
                    [
                        'book_id'    => $post_id,
                        'meta_key'   => 'book_' . $field,
                        'meta_value' => $field_value,
                    ],
                    ['%d', '%s', '%s']
                );
            }
        }
    }
}
add_action('save_post', 'save_book_meta_data');

