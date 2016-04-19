<?php

class pulse_title_widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE TITLE'
        );
        parent::__construct('pulse_title', 'PULSE TITLE', $widget_args);
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance) {
        extract($args);
        echo wp_kses_post($args['before_widget']);

        $title = empty($instance['title']) ? '' : $instance['title'];

        ?>

        <?php
        if (!empty($title)) {
            echo '<span class="content-title">' . $title . '</span>';
        }
        ?>

        <?php
        echo wp_kses_post($args['after_widget']);
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance) {
        // outputs the options form on admin

        $title = empty($instance['title']) ? '' : $instance['title'];

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e(' Title :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('pulse_title_widget');
});

