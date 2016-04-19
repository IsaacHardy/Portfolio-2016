<?php

class pricing extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE PRICING TABLE'
        );
        parent::__construct('pulse_pricing', 'PULSE PRICING TABLE', $widget_args);
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
        $tabletitle = empty($instance['tabletitle']) ? '' : $instance['tabletitle'];
        $price = empty($instance['price']) ? '' : $instance['price'];
        $buttontext = empty($instance['buttontext']) ? '' : $instance['buttontext'];
        $buttonlink = empty($instance['buttonlink']) ? '' : $instance['buttonlink'];
        $pricingdetails = isset($instance['pricingdetails']) ? $instance['pricingdetails'] : array();
        ?>


        <div class="pricing-table-wrapper">

            <div class="pricing-table pricing-monthly">
                <div class="pricing-table-header">
                    <h1><?php echo esc_html($tabletitle); ?></h1>
                    <h3><?php echo esc_html($price); ?></h3>
                </div>
                <div class="pricing-table-content">
                    <ul class="pricing-details">
                        <?php foreach ($pricingdetails as $pricingdetail) { ?>
                            <li class="pricing-list"><?php echo esc_html($pricingdetail['listitem']); ?></li>
                    <?php } ?>
                    </ul>
                    <?php if (!empty($buttontext) and ! empty($buttonlink)) { ?>
                        <a class="signup" href="<?php echo esc_url($buttonlink); ?>"><?php echo esc_html($buttontext); ?></a>
        <?php } ?>
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

        $tabletitle = empty($instance['tabletitle']) ? '' : $instance['tabletitle'];
        $price = empty($instance['price']) ? '' : $instance['price'];
        $buttontext = empty($instance['buttontext']) ? '' : $instance['buttontext'];
        $buttonlink = empty($instance['buttonlink']) ? '' : $instance['buttonlink'];
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('tabletitle')); ?>"><?php esc_html_e(' Table title :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tabletitle')); ?>" name="<?php echo esc_attr($this->get_field_name('tabletitle')); ?>" type="text" value="<?php echo esc_attr($tabletitle); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('price')); ?>"><?php esc_html_e(' Price :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('price')); ?>" name="<?php echo esc_attr($this->get_field_name('price')); ?>" type="text" value="<?php echo esc_attr($price); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('buttontext')); ?>"><?php esc_html_e(' Button text :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('buttontext')); ?>" name="<?php echo esc_attr($this->get_field_name('buttontext')); ?>" type="text" value="<?php echo esc_attr($buttontext); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('buttonlink')); ?>"><?php esc_html_e(' Button link :','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('buttonlink')); ?>" name="<?php echo esc_attr($this->get_field_name('buttonlink')); ?>" type="text" value="<?php echo esc_attr($buttonlink); ?>" />
        </p>
        <?php
        $pricingdetails = isset($instance['pricingdetails']) ? $instance['pricingdetails'] : array();
        $pricingdetails_num = count($pricingdetails);
        $pricingdetails[$pricingdetails_num + 1] = '';
        $pricingdetails_html = array();
        $pricingdetails_counter = 0;


        foreach ($pricingdetails as $pricingdetail) {
            if (isset($pricingdetail['listitem'])) {
                $pricingdetails_html[] = sprintf(
                        '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">List item</label>
                     <input class="widefat" id="" name="%1$s[%2$s][listitem]" type="text" value="%3$s" />
                     </p>
                    <span class="remove-field button button-primary button-large">Remove list item</span></div>
                    ', $this->get_field_name('pricingdetails')
                        , $pricingdetails_counter
                        , esc_attr($pricingdetail['listitem'])
                );
            }


            $pricingdetails_counter += 1;
        }
        print '<strong><h2>Pricing details</h2></strong>' . join($pricingdetails_html);
        ?>
        <script type="text/javascript" >

            var myfieldname = <?php echo json_encode($this->get_field_name('pricingdetails')) ?>;
            var myfieldnum = <?php echo json_encode($pricingdetails_counter - 1) ?>;
            jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'><p><label for=''>List item</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][listitem]' type='text' value='' /></p><span class='remove-field button button-primary button-large'>Remove list item</span></div>");
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
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add list item" id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['tabletitle'] = (!empty($new_instance['tabletitle']) ) ? strip_tags($new_instance['tabletitle']) : '';
        $instance['price'] = (!empty($new_instance['price']) ) ? strip_tags($new_instance['price']) : '';
        $instance['buttontext'] = (!empty($new_instance['buttontext']) ) ? strip_tags($new_instance['buttontext']) : '';
        $instance['buttonlink'] = (!empty($new_instance['buttonlink']) ) ? strip_tags($new_instance['buttonlink']) : '';

        $instance['pricingdetails'] = array();

        if (isset($new_instance['pricingdetails'])) {
            foreach ($new_instance['pricingdetails'] as $pricingdetail) {

                $instance['pricingdetails'][] = $pricingdetail;
            }
        }

        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('pricing');
});
