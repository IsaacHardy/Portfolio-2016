<?php

class ourservice extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE OUR SERVICES'
        );
        parent::__construct('pulse_ourservice', 'PULSE OUR SERVICES', $widget_args);
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
        $ourservices = isset($instance['ourservices']) ? $instance['ourservices'] : array();
        ?>
        <div class="service-section">
            <div class="services-wrap">
                <?php foreach ($ourservices as $ourservice) { ?>
                    <div class="serv-wrap animated slideInDown">
                        <span class="fa serv-icons <?php echo esc_attr($ourservice['faicon']); ?>"></span>
                        <h3><?php echo esc_html($ourservice['servicetitle']); ?></h3>
                        <p><?php echo balanceTags($ourservice['servicedescription'],true); ?></p>
                        <div class="servicelistt">
                            <?php $servicearray = explode("|", $ourservice['servicelist']); ?>
                                <ul>
                                    <?php foreach ($servicearray as $serviceitem) { 
                                        if ($serviceitem != null) {
                                        ?>
                                        <li> <?php echo esc_html($serviceitem); ?></li>
                                        <?php } } ?>
                                </ul>
                        </div>
                    </div>
                <?php } ?>
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

        $ourservices = isset($instance['ourservices']) ? $instance['ourservices'] : array();
        $ourservices_num = count($ourservices);
        $ourservices[$ourservices_num + 1] = '';
        $ourservices_html = array();
        $ourservices_counter = 0;

        foreach ($ourservices as $ourservice) {
            if (!empty($ourservice)) {
                $ourservices_html[] = sprintf(
                        '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">Service title</label>
                     <input class="widefat" id="" name="%1$s[%2$s][servicetitle]" type="text" value="%3$s" />
                     </p>
                     
                    <p>
                        <label for="">Service description</label>
                        <textarea class="widefat" id="" name="%1$s[%2$s][servicedescription]">%4$s</textarea>
                    </p>
                     
                     <p>
                     <label for="">Font awesome icon | Ex : fa-leaf | http://fortawesome.github.io/Font-Awesome/icons/</label>
                     <input class="widefat" id="" name="%1$s[%2$s][faicon]" type="text" value="%5$s" />
                     </p>
                     
                    <p>
                        <label for="">Service list (separated by |)</label>
                        <textarea class="widefat" id="" name="%1$s[%2$s][servicelist]">%6$s</textarea>
                    </p>

                     
                    <span class="remove-field button button-primary button-large">Remove service</span></div>
                    ', $this->get_field_name('ourservices')
                        , $ourservices_counter
                        , esc_attr($ourservice['servicetitle'])
                        , esc_attr($ourservice['servicedescription'])
                        , esc_attr($ourservice['faicon'])
                        , esc_attr($ourservice['servicelist'])
                );
            }


            $ourservices_counter += 1;
        }
        print '<strong><h2>Services</h2></strong>' . join($ourservices_html);
        ?>
        <script type="text/javascript" >

            var myfieldname = <?php echo json_encode($this->get_field_name('ourservices')) ?>;
            var myfieldnum = <?php echo json_encode($ourservices_counter - 1) ?>;
            jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'>\n\
            <p><label for=''>Service title</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][servicetitle]' type='text' value='' /></p>\n\
            <p><label for=''>Service description</label><textarea class='widefat' id='' name='" + myfieldname + "[" + (count + 1) + "][servicedescription]'></textarea></p>\n\
            <p><label for=''>Font awesome icon | Ex : fa-leaf | http://fortawesome.github.io/Font-Awesome/icons/</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][faicon]' type='text' value='' /></p>\n\
            <p><label for=''>Service list Service list (separated by | )</label><textarea class='widefat' id='' name='" + myfieldname + "[" + (count + 1) + "][servicelist]'></textarea></p>\n\
            <span class='remove-field button button-primary button-large'>Remove service</span></div>");
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
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add Service" id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['ourservices'] = array();

        if (isset($new_instance['ourservices'])) {
            foreach ($new_instance['ourservices'] as $ourservice) {

                $instance['ourservices'][] = $ourservice;
            }
        }

        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('ourservice');
});

