<?php
class Books_Category_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'books_category_widget',
            'Books Category Widget',
            array('description' => 'Display books of a selected category in the sidebar')
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $category = $instance['category'];

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Output books based on selected category
        $args = array(
            'post_type'      => 'book',
            'posts_per_page' => 10, // Adjust as needed
            'tax_query'      => array(
                array(
                    'taxonomy' => 'book_category',
                    'field'    => 'slug',
                    'terms'    => $category,
                ),
            ),
        );

        $books_query = new WP_Query($args);

        if ($books_query->have_posts()) {
            echo '<ul>';
            while ($books_query->have_posts()) {
                $books_query->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p>No books found.</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $category = isset($instance['category']) ? esc_attr($instance['category']) : '';

        // Widget Title
        echo '<p>';
        echo '<label for="' . $this->get_field_id('title') . '">Title:</label>';
        echo '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '">';
        echo '</p>';

        // Category Dropdown
        echo '<p>';
        echo '<label for="' . $this->get_field_id('category') . '">Select Category:</label>';
        echo '<select class="widefat" id="' . $this->get_field_id('category') . '" name="' . $this->get_field_name('category') . '">';
        $categories = get_terms('book_category');
        foreach ($categories as $cat) {
            echo '<option value="' . esc_attr($cat->slug) . '" ' . selected($category, $cat->slug, false) . '>' . esc_html($cat->name) . '</option>';
        }
        echo '</select>';
        echo '</p>';
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['category'] = (!empty($new_instance['category'])) ? strip_tags($new_instance['category']) : '';
        return $instance;
    }
}

function register_books_category_widget() {
    register_widget('Books_Category_Widget');
}
add_action('widgets_init', 'register_books_category_widget');
