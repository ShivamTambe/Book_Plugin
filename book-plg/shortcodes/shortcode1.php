<?php
// Add the shortcode function to your theme's functions.php file or a custom plugin
function book_shortcode($atts) {
    // Define shortcode attributes with defaults
    $atts = shortcode_atts(array(
        'id'           => null,
        'author_name'  => null,
        'year'         => null,
        'category'     => null,
        'tag'          => null,
        'publisher'    => null,
    ), $atts, 'book');

    // Build the query arguments based on provided attributes
    $query_args = array(
        'post_type' => 'book',
        'posts_per_page' => 10, // Display all books if no specific ID or attributes are provided
    );

    foreach ($atts as $key => $value) {
        if (!empty($value)) {
            $query_args[$key] = $value;
        }
    }

    // Query for books
    $books_query = new WP_Query($query_args);
    // Display book information
    ob_start();

    if ($books_query->have_posts()) {
        while ($books_query->have_posts()) {
            $books_query->the_post();

            global $wpdb;
            $author_name = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s", get_the_ID(), 'book_author_name'));
            $publisher = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s", get_the_ID(), 'book_publisher'));
            $year = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_book_meta WHERE book_id = %d AND meta_key = %s",get_the_ID(), 'book_year'));

            // Assuming $book_id is the ID of the book you want to display
            $book_id = get_the_ID();

            // Retrieve and display categories
            $categories = get_the_terms($book_id, 'book_category');
            $tags = get_the_terms($book_id, 'book_tag');

            // Display book information here. You can customize this part based on your book structure.
            /* echo '<div class="book-info">';
            echo '<h2>' . get_the_title() . '</h2>';
            echo '<p>Author: ' . get_post_meta(get_the_ID(), 'book_author_name', true) . '</p>';
            echo '<p>Year: ' . get_post_meta(get_the_ID(), 'book_year', true) . '</p>';
            echo '<p>Category: ' . get_post_meta(get_the_ID(), 'book_category', true) . '</p>';
            echo '<p>Tag: ' . get_post_meta(get_the_ID(), 'book_tag', true) . '</p>';
            echo '<p>Publisher: ' . get_post_meta(get_the_ID(), 'book_publisher', true) . '</p>';
            echo '</div>';
            */

            echo '<div class="book-info">';
            echo '<h2>' . get_the_title() . '</h2>';
            echo '<p>Author: ' . $author_name . '</p>';
            echo '<p>Year: ' . $year . '</p>';
            echo '<p>Publisher: ' . $publisher . '</p>';

           // Display categories
            if (!empty($tags)) {
                echo '<p>Tags: ';
                foreach ($tags as $tag) {
                    echo $tag->name . ', ';
                }
                echo '</p>';
            }

            // Display Tag
            if (!empty($categories)) {
                echo '<p>Categories: ';
                foreach ($categories as $category) {
                    echo $category->name . ', ';
                }
                echo '</p>';
            }

            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo '<p>No books found.</p>';
    }

    return ob_get_clean();
}
add_shortcode('book', 'book_shortcode');
