<?php
// Custom Functionality
function theme_register_sidebar() {
    register_sidebar(
        array(
            'name'          => esc_html__('Main Sidebar', 'twentytwentyfour'),
            'id'            => 'main-sidebar',
            'description'   => esc_html__('Widgets added here will appear in the main sidebar.', 'twentytwentyfour'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'theme_register_sidebar');