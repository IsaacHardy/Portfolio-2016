<?php

class skills extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE SKILLS'
        );
        parent::__construct('pulse_skills', 'PULSE SKILLS', $widget_args);
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
        $percentage = empty($instance['percentage']) ? '' : $instance['percentage'];
        $level = empty($instance['level']) ? '' : $instance['level'];
        $experience = empty($instance['experience']) ? '' : $instance['experience'];
        $description = empty($instance['description']) ? '' : $instance['description'];
        $skilltags = isset( $instance['skilltags'] ) ? $instance['skilltags'] : array();
        ?>
                        <div class="skolls">
                            <span class="skilltitle"><?php echo esc_html($title); ?> > </span>
                            <span class="skill-description"><?php echo balanceTags($description,true); ?></span>
                            <div class="bar-main-container">
                                <div class="wrap">
                                    <div class="bar-percentage" data-percentage="<?php echo esc_attr($percentage); ?>"></div>
                                    <?php if(!empty($level)) { ?>
                                    <span class="skill-detail"><i class="fa fa-bar-chart"></i><?php esc_html_e('LEVEL : ', 'pulse'); ?><?php echo esc_html($level); ?></span>
                                    <?php  } 
                                    if(!empty($experience)) {
                                    ?>
                                    <span class="skill-detail"><i class="fa fa-binoculars"></i><?php esc_html_e('EXPERIENCE : ', 'pulse'); ?><?php echo esc_html($experience); ?></span>
                                    <?php } ?>
                                    <?php if(!empty($percentage)) { ?>
                                    <div class="bar-container">
                                        <div class="bar"></div>
                                    </div>
                                    <?php } ?>
                                    <?php foreach ($skilltags as $skilltag) { ?>
                                    <span class="label labelsection"><?php echo esc_html($skilltag['tag']);  ?></span>
                                    <?php } ?>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        </div>


<?php

        echo wp_kses_post($args['after_widget']);
        
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance) {

        $title = empty($instance['title']) ? '' : $instance['title'];
        $percentage = empty($instance['percentage']) ? '' : $instance['percentage'];
        $level = empty($instance['level']) ? '' : $instance['level'];
        $experience = empty($instance['experience']) ? '' : $instance['experience'];
        $description = empty($instance['description']) ? '' : $instance['description'];
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e(' Title :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('percentage')); ?>"><?php esc_html_e(' Percentage :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('percentage')); ?>" name="<?php echo esc_attr($this->get_field_name('percentage')); ?>" type="text" value="<?php echo esc_attr($percentage); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('level')); ?>"><?php esc_html_e(' Level :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('level')); ?>" name="<?php echo esc_attr($this->get_field_name('level')); ?>" type="text" value="<?php echo esc_attr($level); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('experience')); ?>"><?php esc_html_e(' Experience :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('experience')); ?>" name="<?php echo esc_attr($this->get_field_name('experience')); ?>" type="text" value="<?php echo esc_attr($experience); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php esc_html_e(' Description:','pulse'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_attr($description); ?></textarea>
        </p>
        <?php
        $skilltags = isset($instance['skilltags']) ? $instance['skilltags'] : array();
        $skilltags_num = count($skilltags);
        $skilltags[$skilltags_num + 1] = '';
        $skilltags_html = array();
        $skilltags_counter = 0;


        foreach ($skilltags as $skilltag) {
            if (isset($skilltag['tag'])) {
                $skilltags_html[] = sprintf(
                        '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">Skill tag</label>
                     <input class="widefat" id="" name="%1$s[%2$s][tag]" type="text" value="%3$s" />
                     </p>
                    <span class="remove-field button button-primary button-large">Remove skill tag</span></div>
                    ', $this->get_field_name('skilltags')
                        , $skilltags_counter
                        , esc_attr($skilltag['tag'])
                );
            }


            $skilltags_counter += 1;
        }
        print '<strong><h2>Skills tags</h2></strong>' . join($skilltags_html);
        ?>
        <script type="text/javascript" >
           
            var myfieldname = <?php echo json_encode($this->get_field_name('skilltags')) ?>;
            var myfieldnum = <?php echo json_encode($skilltags_counter-1) ?>;
                        jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'><p><label for=''>Skill tag</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][tag]' type='text' value='' /></p><span class='remove-field button button-primary button-large'>Remove tag</span></div>");
                            count++;
                });
                $(".remove-field").live('click', function () {
                    $(this).parent().remove();
                });

            });


        </script>


        <span id="<?php echo esc_attr($this->get_field_id('field_clone')); ?>">

        </span>
        <?php
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add skill tag" id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['percentage'] = ( ! empty( $new_instance['percentage'] ) ) ? strip_tags( $new_instance['percentage'] ) : '';
        $instance['level'] = ( ! empty( $new_instance['level'] ) ) ? strip_tags( $new_instance['level'] ) : '';
        $instance['experience'] = ( ! empty( $new_instance['experience'] ) ) ? strip_tags( $new_instance['experience'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? balanceTags($new_instance['description'],true) : '';

        $instance['skilltags'] = array();

        if ( isset( $new_instance['skilltags'] ) )
        {
            foreach ( $new_instance['skilltags'] as $skilltag )
            {
                
                    $instance['skilltags'][] = $skilltag;
            }
        }

        return $instance;

    }

}

add_action('widgets_init', function() {
    register_widget('skills');
});
