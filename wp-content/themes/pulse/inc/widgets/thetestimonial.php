<?php

class thetestimonial extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE TESTIMONIALS'
        );
        parent::__construct('pulse_thetestimonials', 'PULSE TESTIMONIALS', $widget_args);
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
        $testimonials = isset($instance['testimonials']) ? $instance['testimonials'] : array();
        ?>
        <div class="testimonials-container">
            <?php foreach ($testimonials as $testimonial) { ?>
                <div class="testimonial testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>">

                    <figure class="testimonial__mug">
                        <img src="<?php echo esc_url($testimonial['clientpic']); ?>" height="100" width="100" alt="<?php esc_html_e("clientpicture","pulse"); ?>">
                    </figure>
                    <p>&ldquo;<?php echo balanceTags($testimonial['testimon'],true); ?>&rdquo;
                        <br><strong><?php echo esc_html($testimonial['name']); ?>, <?php echo esc_html($testimonial['location']); ?></strong>
                    </p>
                </div>
            <?php } ?>
            <button class="prev-testimonial prev-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>">Prev</button>
            <button class="prev-testimonial next-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>">Next</button>
        </div>
        <div class="aftertesti"></div>
        <script type="text/javascript">
            jQuery(function ($) {


                function explode() {
                    $('.aftertesti').height(1);
                }
                setTimeout(explode, 500);



                var testimonials<?php echo str_replace("-", "_", $args['widget_id']); ?> = {};

                testimonials<?php echo str_replace("-", "_", $args['widget_id']); ?>.slider = (function () {
                    var currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?> = 0,
                            prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?> = $('.prev-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>'),
                            nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?> = $('.next-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>'),
                            items<?php echo str_replace("-", "_", $args['widget_id']); ?> = (function () {
                                var items<?php echo str_replace("-", "_", $args['widget_id']); ?> = [];
                                $('.testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>').each(function () {
                                    items<?php echo str_replace("-", "_", $args['widget_id']); ?>.push($(this));
                                });
                                return items<?php echo str_replace("-", "_", $args['widget_id']); ?>;
                            })();

                    function getCurrent() {
                        $('.testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>').each(function (index) {
                            $(this).removeClass('current');
                        });
                        $('.testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>').eq(currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?>).addClass('current');
                    }

                    function greyOut(prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>, nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>) {
                        if ($(prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>).hasClass('grey-out')) {
                            $(prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>).removeClass('grey-out');
                        }
                        if ($(nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>).hasClass('grey-out')) {
                            $(nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>).removeClass('grey-out');
                        }
                        if (currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?> == 0) {
                            $(prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>).addClass('grey-out');
                        }
                        if (currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?> == items<?php echo str_replace("-", "_", $args['widget_id']); ?>.length - 1) {
                            $(nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>).addClass('grey-out');
                        }
                    }

                    return {
                        init: function (prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>, nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>) {
                            items<?php echo str_replace("-", "_", $args['widget_id']); ?>[currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?>].addClass('current');
                            greyOut(prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>, nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>);
                            $(prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>).click(function () {
                                if (currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?> > 0) {
                                    currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?>--;
                                }
                                getCurrent();
                                greyOut(prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>, nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>);
                            });
                            $(nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>).click(function () {
                                if (currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?> < items<?php echo str_replace("-", "_", $args['widget_id']); ?>.length - 1) {
                                    currentItemIndex<?php echo str_replace("-", "_", $args['widget_id']); ?>++;
                                }
                                getCurrent();
                                greyOut(prevBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>, nextBtn<?php echo str_replace("-", "_", $args['widget_id']); ?>);
                            });
                        }
                    };

                })();

                testimonials<?php echo str_replace("-", "_", $args['widget_id']); ?>.slider.init('.prev-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>', '.next-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>');

            });
        </script>
            <style>
            .testimonials-container {
                position: relative;
                text-align: center;
                overflow: hidden;
                padding: 6px 20px;
                margin-bottom: 15px;
                border: 1px solid #DBDBE0;
                background: rgba(248, 249, 251, 0.6);
            }

            .testimonials-container p {
                width: 75%;
                text-align: center;
                display: inline-block;
            }

            .testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?> {
                position: absolute;
                opacity: 0;
                z-index: -1;
            }

            .testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>.current {
                opacity: 1;
                position: relative;
                z-index: initial;
                -moz-animation: fadein 0.7s ease;
                -webkit-animation: fadein 0.7s ease;
                animation: fadein 0.7s ease;
            }

            .prev-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>,
            .next-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?> {
                position: absolute;
                -moz-appearance: none;
                -webkit-appearance: none;
                background-color: transparent;
                border: none;
                margin: 0 20px;
                width: 30px;
                top: 110px;
                text-indent: -9999px;
                cursor: pointer;
            }

            .prev-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>:focus,
            .next-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>:focus {
                outline: none;
            }

            .prev-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>:before,
            .next-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>:before {
                content: "";
                width: 30px;
                height: 30px;
                display: inline-block;
                position: absolute;
                top: 0;
                -moz-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                -webkit-transform: rotate(45deg);
                transform: rotate(45deg);
            }

            .prev-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?> {
                left: 0;
            }

            .prev-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>:before {
                left: 10px;
                border-left: solid 1px black;
                border-bottom: solid 1px black;
            }

            .next-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?> {
                right: 0;
            }

            .next-testimonial<?php echo str_replace("-", "_", $args['widget_id']); ?>:before {
                right: 10px;
                border-top: solid 1px black;
                border-right: solid 1px black;
            }

            .testimonial__mug {
                width: 100px;
                height: 100px;
                margin: 16px auto;
                -moz-border-radius: 50%;
                -webkit-border-radius: 50%;
                border-radius: 50%;
                overflow: hidden;
            }

            .grey-out {
                opacity: .2;
            }
        </style>
        


        <?php
        echo wp_kses_post($args['after_widget']);
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance) {
 
        $testimonials = isset($instance['testimonials']) ? $instance['testimonials'] : array();
        $testimonials_num = count($testimonials);
        $testimonials[$testimonials_num + 1] = '';
        $testimonials_html = array();
        $testimonials_counter = 0;

        foreach ($testimonials as $testimonial) {
            if (!empty($testimonial)) {
                $testimonials_html[] = sprintf(
                        '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">Name</label>
                     <input class="widefat" id="" name="%1$s[%2$s][name]" type="text" value="%3$s" />
                     </p>
                     
                     <p>
                     <label for="">Location</label>
                     <input class="widefat" id="" name="%1$s[%2$s][location]" type="text" value="%4$s" />
                     </p>
                    
 <p>
                        <label for="">Testimonial</label>
                        <textarea class="widefat" id="" name="%1$s[%2$s][testimon]">%5$s</textarea>
                    </p>
                    
                    <p>
                    <label for="">Client picture (150 x 150)</label>
                    <input id="urlclientpic" name="%1$s[%2$s][clientpic]"  class="widefat" type="text" size="36"  value="%6$s" />
                    <input class="button button-primary button-large upload_ourclient" type="button" value="Upload client picture"/>

                    <span class="remove-field button button-primary button-large">Remove testimonial</span></div>
                    ', $this->get_field_name('testimonials')
                        , $testimonials_counter
                        , esc_attr($testimonial['name'])
                        , esc_attr($testimonial['location'])
                        , esc_attr($testimonial['testimon'])
                        , esc_attr($testimonial['clientpic'])
                );
            }


            $testimonials_counter += 1;
        }
        print '<strong><h2>Clients testimonials</h2></strong>' . join($testimonials_html);
        ?>
        <script type="text/javascript" >

            var myfieldname = <?php echo json_encode($this->get_field_name('testimonials')) ?>;
            var myfieldnum = <?php echo json_encode($testimonials_counter - 1) ?>;
            jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'>\n\
            <p><label for=''>Name</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][name]' type='text' value='' /></p>\n\
            <p><label for=''>Location</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][location]' type='text' value='' /></p>\n\
            <p><label for=''>Testimonial</label><textarea class='widefat' id='' name='" + myfieldname + "[" + (count + 1) + "][testimon]'></textarea></p>\n\
            <p><label for=''>Client picture (150 x 150)</label><input id='urlclientpic' class='widefat' name='" + myfieldname + "[" + (count + 1) + "][clientpic]' type='text' value='' /><input class='button button-primary button-large upload_ourclient' type='button' value='Upload client picture'/></p>\n\
            <span class='remove-field button button-primary button-large'>Remove testimonial</span></div>");
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
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add testimonial " id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['testimonials'] = array();

        if (isset($new_instance['testimonials'])) {
            foreach ($new_instance['testimonials'] as $testimonial) {

                $instance['testimonials'][] = $testimonial;
            }
        }

        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('thetestimonial');
});

