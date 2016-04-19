<?php

class resume_sections extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE RESUME SECTIONS'
        );
        parent::__construct('pulse_resume_sections', 'PULSE RESUME SECTIONS', $widget_args);
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
        $secicon = empty($instance['secicon']) ? '' : $instance['secicon'];
        $resumes = isset( $instance['resumes'] ) ? $instance['resumes'] : array();
        ?>
                        <div class="resume-wrapper">
                            <ul class="resume">
                                <?php foreach ($resumes as $resume) { ?>
                                <li>
                                    <div class="resume-tag">
                                        <span class="fa <?php echo esc_attr($secicon ); ?>"></span>
                                        <div class="resume-date">
                                            <span><?php echo esc_html($resume['date1']);  ?></span>
                                            <div class="separator"></div>
                                            <span><?php echo esc_html($resume['date2']);  ?></span>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <?php if (!empty($resume['location'])) { ?>
                                        <span class="timeline-location"><i class="fa fa-map-marker"></i><?php echo esc_html($resume['location']);  ?></span>
                                        <?php } ?>
                                        <h3 class="timeline-header"><?php echo esc_html($resume['sectiontitle']);  ?></h3>
                                        <div class="timeline-body">
                                            <h4><?php echo esc_html($resume['company']);  ?></h4>
                                            <span><?php echo  balanceTags($resume['description'],true);  ?></span>
                                        </div>
                                    </div>
                                </li>
                                            
                                      <?php  } ?>
                                
                            </ul>
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
        $icons = smk_font_awesome(); //The array
        $secicon = empty($instance['secicon']) ? '' : $instance['secicon'];
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('secicon')); ?>"><?php esc_html_e(' Section icon:','pulse'); ?></label>
            <select name="<?php echo esc_attr($this->get_field_name('secicon')); ?>" id="<?php echo esc_attr($this->get_field_id('secicon')); ?>" class="widefat" style="font-family: 'FontAwesome', 'Open Sans';">
        <?php foreach ($icons as $icon => $iconcode) { ?>
                <option value="<?php echo esc_attr($icon); ?>" <?php if($secicon == $icon){echo 'selected="selected"';} ?>  ><?php echo str_replace("\\", "&#x", $iconcode) . '; ' . $icon; ?></option>
        <?php } ?>
            </select>
        </p>
        <?php
        $resumes = isset($instance['resumes']) ? $instance['resumes'] : array();
        $resumes_num = count($resumes);
        $resumes[$resumes_num + 1] = '';
        $resumes_html = array();
        $resumes_counter = 0;

        foreach ($resumes as $resume) {
            if (isset($resume['sectiontitle']) || isset($resume['company']) || isset($resume['description']) || isset($resume['location']) || isset($resume['date1']) || isset($resume['date2'])) {
                $resumes_html[] = sprintf(
                        '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">Section title</label>
                     <input class="widefat" id="" name="%1$s[%2$s][sectiontitle]" type="text" value="%3$s" />
                     </p>
                     
                     <p>
                     <label for="">institute / company</label>
                     <input class="widefat" id="" name="%1$s[%2$s][company]" type="text" value="%4$s" />
                     </p>
                     
                    <p>
                        <label for="">Description</label>
                        <textarea class="widefat" id="" name="%1$s[%2$s][description]">%5$s</textarea>
                    </p>
                    
                    <p>
                     <label for="">Location</label>
                     <input class="widefat" id="" name="%1$s[%2$s][location]" type="text" value="%6$s" />
                     </p>
                     
                    <p>
                     <label for="">Date 1</label>
                     <input class="widefat" id="" name="%1$s[%2$s][date1]" type="text" value="%7$s" />
                     </p>
                     
                    <p>
                     <label for="">Date 2</label>
                     <input class="widefat" id="" name="%1$s[%2$s][date2]" type="text" value="%8$s" />
                     </p>

                    <span class="remove-field button button-primary button-large">Remove tab</span></div>
                    ', $this->get_field_name('resumes')
                        , $resumes_counter
                        , esc_attr($resume['sectiontitle'])
                        , esc_attr($resume['company'])
                        , esc_attr($resume['description'])
                        , esc_attr($resume['location'])
                        , esc_attr($resume['date1'])
                        , esc_attr($resume['date2'])
                );
            }


            $resumes_counter += 1;
        }
        print '<strong><h2>RESUME SECTIONS</h2></strong>' . join($resumes_html);
        ?>
         <script type="text/javascript" >
           
            var myfieldname = <?php echo json_encode($this->get_field_name('resumes')) ?>;
            var myfieldnum = <?php echo json_encode($resumes_counter-1) ?>;
                        jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'><p><label for=''>Section Title</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][sectiontitle]' type='text' value='' /></p><p><label for=''>institute / company</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][company]' type='text' value='' /></p><p><label for=''>Description</label><textarea class='widefat' id='' name='" + myfieldname + "[" + (count + 1) + "][description]'></textarea></p><p><label for=''>Location</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][location]' type='text' value='' /></p><p><label for=''>Date 1</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][date1]' type='text' value='' /></p><p><label for=''>Date 2</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][date2]' type='text' value='' /></p><span class='remove-field button button-primary button-large'>Remove resume section</span></div>");
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
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add resume section" id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['secicon'] = (!empty($new_instance['secicon']) ) ? strip_tags($new_instance['secicon']) : '';

        $instance['resumes'] = array();

        if (isset($new_instance['resumes'])) {
            foreach ($new_instance['resumes'] as $resume) {

                $instance['resumes'][] = $resume;
            }
        }

        return $instance;
    }

}


add_action('widgets_init', function() {
    register_widget('resume_sections');
});

