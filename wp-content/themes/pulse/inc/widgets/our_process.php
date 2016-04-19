<?php

class our_process extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE OUR PROCESS'
        );
        parent::__construct('pulse_our_process', 'PULSE OUR PROCESS', $widget_args);
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
        $nextbut = empty($instance['nextbut']) ? '' : $instance['nextbut'];
        $prevbut = empty($instance['prevbut']) ? '' : $instance['prevbut'];
        $ourprocess = isset( $instance['ourprocess'] ) ? $instance['ourprocess'] : array();
        $len = count($ourprocess);
        ?>                  
<style scoped>
    .proceess_wrap #progressbar li {
    width: <?php echo 100 / $len.'%'; ?>;
}
</style>         
      
      <div class="proceess_wrap">
                            <div id="ourprocess">
                                <ul id="progressbar">
                                    <?php foreach ($ourprocess as $key => $ourproces) {?>
                                    <?php if($key == 0) { ?>
                                    <li class="active"><?php echo esc_html($ourproces['proctitle']);  ?></li>
                                    <?php } else { ?>
                                    <li><?php echo esc_html($ourproces['proctitle']);  ?></li>
                                    <?php }  ?>
                                    <?php } ?>
                                </ul>
                                
                                    <?php foreach ($ourprocess as $key => $ourproces) {?>
                                    <?php if($key == 0) { ?>
                                    <div class="proceess">  
                                        <h3><?php echo esc_html($key) + 1  .". ".$ourproces['proctitle'];  ?></h3>
                                        <p><?php echo balanceTags($ourproces['proccontent'],true);  ?></p>
                                        <input type="button" name="next" class="next action-button" value="<?php echo esc_attr($nextbut);  ?>" />
                                    </div>
                                    <?php } else if ($key == $len - 1) { ?>
                                     <div class="proceess">
                                        <h3><?php echo esc_html($key) + 1  .". ".$ourproces['proctitle'];  ?></h3>
                                        <p><?php echo balanceTags($ourproces['proccontent'],true);  ?></p>

                                        <input type="button" name="previous" class="previous action-button" value="<?php echo esc_attr($prevbut);  ?>" />
                                    </div>
                                     <?php } else { ?>
                                    <div class="proceess">
                                    <h3><?php echo esc_html($key) + 1  .". ".$ourproces['proctitle'];  ?></h3>
                                        <p><?php echo balanceTags($ourproces['proccontent'],true);  ?></p>

                                        <input type="button" name="previous" class="previous action-button" value="<?php echo esc_attr($prevbut);  ?>" />
                                        <input type="button" name="next" class="next action-button" value="<?php echo esc_attr($nextbut);  ?>" />
                                    </div>
                                   <?php } ?>
                                    <?php } ?>
                                    <div style="clear:both;"></div>
                                
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

        $nextbut = empty($instance['nextbut']) ? '' : $instance['nextbut'];
        $prevbut = empty($instance['prevbut']) ? '' : $instance['prevbut'];
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('nextbut')); ?>"><?php esc_html_e(' Next button text :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('nextbut')); ?>" name="<?php echo esc_attr($this->get_field_name('nextbut')); ?>" type="text" value="<?php echo esc_attr($nextbut); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('prevbut')); ?>"><?php esc_html_e(' Previous button text :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('prevbut')); ?>" name="<?php echo esc_attr($this->get_field_name('prevbut')); ?>" type="text" value="<?php echo esc_attr($prevbut); ?>" />
        </p>
        <?php
        $ourprocess = isset($instance['ourprocess']) ? $instance['ourprocess'] : array();
        $ourprocess_num = count($ourprocess);
        $ourprocess[$ourprocess_num + 1] = '';
        $ourprocess_html = array();
        $ourprocess_counter = 0;


        foreach ($ourprocess as $ourproces) {
            if (isset($ourproces['proctitle']) || isset($ourproces['proccontent'])) {
                $ourprocess_html[] = sprintf(
                        '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">Process Title</label>
                     <input class="widefat" id="" name="%1$s[%2$s][proctitle]" type="text" value="%3$s" />
                     </p>
                     <p>
                        <label for="">Process Content</label>
                        <textarea class="widefat" id="" name="%1$s[%2$s][proccontent]">%4$s</textarea>
                    </p>
                    
                    <span class="remove-field button button-primary button-large">Remove process item</span></div>
                    ', $this->get_field_name('ourprocess')
                        , $ourprocess_counter
                        , esc_attr($ourproces['proctitle'])
                        , esc_attr($ourproces['proccontent'])
                );
            }


            $ourprocess_counter += 1;
        }
        print '<strong><h2>Process items</h2></strong>' . join($ourprocess_html);
        ?>
        <script type="text/javascript" >
           
            var myfieldname = <?php echo json_encode($this->get_field_name('ourprocess')) ?>;
            var myfieldnum = <?php echo json_encode($ourprocess_counter-1) ?>;
                        jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'><p><label for=''>Process Title</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][proctitle]' type='text' value='' /></p><p><label for=''>Process Content</label><textarea class='widefat' id='' name='" + myfieldname + "[" + (count + 1) + "][proccontent]'></textarea></p><span class='remove-field button button-primary button-large'>Remove process item</span></div>");
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
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add process item" id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['nextbut'] = ( ! empty( $new_instance['nextbut'] ) ) ? strip_tags( $new_instance['nextbut'] ) : '';
        $instance['prevbut'] = ( ! empty( $new_instance['prevbut'] ) ) ? strip_tags( $new_instance['prevbut'] ) : '';

        $instance['ourprocess'] = array();

        if ( isset( $new_instance['ourprocess'] ) )
        {
            foreach ( $new_instance['ourprocess'] as $ourproces )
            {
                
                    $instance['ourprocess'][] = $ourproces;
            }
        }

        return $instance;

    }

}

add_action('widgets_init', function() {
    register_widget('our_process');
});
