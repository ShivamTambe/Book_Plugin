<?php
// Add a menu item under the Books menu
function add_book_settings_menu() {
    add_submenu_page(
        'edit.php?post_type=book', // Parent menu (Books)
        'Book Settings',           // Page title
        'Settings',                // Menu title
        'manage_options',          // Capability
        'book_settings',           // Menu slug
        'display_book_settings_page', // Callback function to display the settings page
        'dashicons-admin-generic', // Icon (optional)
        30 // Menu position
    );
}
add_action('admin_menu', 'add_book_settings_menu');

// Register settings and fields
function book_settings_init() {
    register_setting('book_settings_group', 'book_currency');
    register_setting('book_settings_group', 'books_per_page');

    add_settings_section(
        'book_settings_section',
        'Book Settings',
        'book_settings_section_callback',
        'book_settings'
    );

    add_settings_field(
        'book_currency',
        'Currency',
        'book_currency_callback',
        'book_settings',
        'book_settings_section'
    );

    add_settings_field(
        'books_per_page',
        'Books Per Page',
        'books_per_page_callback',
        'book_settings',
        'book_settings_section'
    );
}
add_action('admin_init', 'book_settings_init');

// Section callback function
function book_settings_section_callback() {
    echo '<p>Configure book settings below:</p>';
}

// Field callback functions
function book_currency_callback() {
    $currency = esc_attr(get_option('book_currency', 'USD'));
    echo '<input type="text" name="book_currency" value="' . $currency . '" />';
}

function books_per_page_callback() {
    $books_per_page = esc_attr(get_option('books_per_page', 10));
    echo '<input type="number" name="books_per_page" value="' . $books_per_page . '" />';
}

// Display the settings page
function display_book_settings_page() {
    ?>
    <div class="wrap">
        <h2>Book Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('book_settings_group'); ?>
            <?php do_settings_sections('book_settings'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
