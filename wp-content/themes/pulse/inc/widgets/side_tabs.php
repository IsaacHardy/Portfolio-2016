<?php

class side_tabs extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE SIDE TABS'
        );
        parent::__construct('pulse_side_tabs', 'PULSE SIDE TABS', $widget_args);
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
        $mytabs = isset( $instance['mytabs'] ) ? $instance['mytabs'] : array();

        ?>
        <div class="verticaltab">


            <ul class="nav nav-tabs nav-tabs-left nav-centered" role="tablist">
                <?php foreach ($mytabs as $key => $mytab) {?>
                <?php if($key == 0) { ?>
                <li role="presentation" class="active">
                    <a href="#<?php echo str_replace(" ","_",$mytab['tabtitle']);  ?>" data-toggle="tab" role="tab">
                        <span class="fa <?php echo esc_attr($mytab['faicontab']) ; ?>"></span>
                    </a>
                </li>
                <?php } else { ?>
                <li role="presentation">
                    <a href="#<?php echo str_replace(" ","_",$mytab['tabtitle']);  ?>" data-toggle="tab" role="tab">
                        <span class="fa <?php echo esc_attr($mytab['faicontab']) ; ?>"></span>
                    </a>
                </li>
                    <?php }  ?>
                <?php } ?>
            </ul>

            <div id="my_side_tabs" class="tab-content side-tabs side-tabs-left">
                <?php foreach ($mytabs as $key => $mytab) { ?>
                <?php if($key == 0) { ?>
                <div class="tab-pane fade in active" id="<?php echo str_replace(" ","_",$mytab['tabtitle']);  ?>" role="tabpanel">
                    <h3 class="mytabtitle"><?php echo esc_html($mytab['tabtitle']);  ?></h3>
                    <h4 class="mytabsubtitle"><?php echo esc_html($mytab['subtitle']);  ?></h4>
                    <div class="tabcon"><?php echo balanceTags($mytab['content'],true);  ?></div>

                </div>
                <?php } else { ?>
                <div class="tab-pane fade" id="<?php echo str_replace(" ","_",$mytab['tabtitle']);  ?>" role="tabpanel">
                    <h3 class="mytabtitle"><?php echo esc_html($mytab['tabtitle']);  ?></h3>
                    <h4 class="mytabsubtitle"><?php echo esc_html($mytab['subtitle']);  ?></h4>
                    <div class="tabcon"><?php echo balanceTags($mytab['content'],true);  ?></div>

                </div>
                    <?php }  ?>
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


        $mytabs = isset($instance['mytabs']) ? $instance['mytabs'] : array();
        $mytabs_num = count($mytabs);
        $mytabs[$mytabs_num + 1] = '';
        $mytabs_html = array();
        $mytabs_counter = 0;


        foreach ($mytabs as $mytab) {
            if (isset($mytab['tabtitle']) || isset($mytab['subtitle']) || isset($mytab['content'])) {
                $mytabs_html[] = sprintf(
                    '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">Tab Title</label>
                     <input class="widefat" id="" name="%1$s[%2$s][tabtitle]" type="text" value="%3$s" />
                     </p>

                     <p>
                     <label for="">Tab subtitle</label>
                     <input class="widefat" id="" name="%1$s[%2$s][subtitle]" type="text" value="%4$s" />
                     </p>


                    <p>
                        <label for="">Tab Content</label>
                        <textarea class="widefat" id="" name="%1$s[%2$s][content]">%5$s</textarea>
                    </p>

                    <p>
                     <label for="">Font awesome icon | Ex : fa-leaf | http://fortawesome.github.io/Font-Awesome/icons/</label>
                     <input class="widefat" id="" name="%1$s[%2$s][faicontab]" type="text" value="%6$s" />
                     </p>

                    <span class="remove-field button button-primary button-large">Remove tab</span></div>
                    ', $this->get_field_name('mytabs')
                    , $mytabs_counter
                    , esc_attr($mytab['tabtitle'])
                    , esc_attr($mytab['subtitle'])
                    , esc_attr($mytab['content'])
                    , esc_attr($mytab['faicontab'])
                );
            }


            $mytabs_counter += 1;
        }
        print '<strong><h2>TABS</h2></strong>' . join($mytabs_html);
        ?>
        <script type="text/javascript" >

            var myfieldname = <?php echo json_encode($this->get_field_name('mytabs')) ?>;
            var myfieldnum = <?php echo json_encode($mytabs_counter-1) ?>;
            jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'><p><label for=''>Tab Title</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][tabtitle]' type='text' value='' /></p><p><label for=''>Tab subtitle</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][subtitle]' type='text' value='' /></p><p><label for=''>Tab Content</label><textarea class='widefat' id='' name='" + myfieldname + "[" + (count + 1) + "][content]'></textarea></p><p><label for=''>Font awesome icon | Ex : fa-leaf | http://fortawesome.github.io/Font-Awesome/icons/</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][faicontab]' type='text' value='' /></p><span class='remove-field button button-primary button-large'>Remove tab</span></div>");
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
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add tab" id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['mytabs'] = array();

        if ( isset( $new_instance['mytabs'] ) )
        {
            foreach ( $new_instance['mytabs'] as $mytab )
            {

                $instance['mytabs'][] = $mytab;
            }
        }

        return $instance;

    }

}

add_action('widgets_init', function() {
    register_widget('side_tabs');
});
