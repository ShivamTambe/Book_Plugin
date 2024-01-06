<?php
// Function to display top book categories on the dashboard
function custom_dashboard_widget() {
    // Get the top 5 book categories based on count
    $categories = get_terms('book_category', array(
        'orderby'    => 'count',
        'order'      => 'DESC',
        'number'     => 5,
        'hide_empty' => false, // Set to true if you want to hide empty categories
    ));

    // Display the categories
    if (!empty($categories)) {
        echo '<ul>';
        foreach ($categories as $category) {
            echo '<li>' . esc_html($category->name) . ' - ' . esc_html($category->count) . ' books</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No book categories found.</p>';
    }
}

// Function to add the custom dashboard widget
function add_custom_dashboard_widget() {
    wp_add_dashboard_widget(
        'custom_dashboard_widget',
        'Top Book Categories',
        'custom_dashboard_widget'
    );
}

// Hook to add the custom dashboard widget
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');
