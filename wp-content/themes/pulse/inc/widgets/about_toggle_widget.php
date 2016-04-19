<?php

class about_toggle_widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE ABOUT ME'
        );
        parent::__construct('pulse_about_toggle', 'PULSE ABOUT ME', $widget_args);
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

        //$title = empty($instance['title']) ? '' : $instance['title'];
        $mymail = empty($instance['mymail']) ? '' : $instance['mymail'];
        $mytel = empty($instance['mytel']) ? '' : $instance['mytel'];
        $mydescription = empty($instance['mydescription']) ? '' : $instance['mydescription'];
        $freelance = empty($instance['freelance']) ? false : $instance['freelance'] === "YES";
        $maplati = empty($instance['maplati']) ? '' : $instance['maplati'];
        $maplong = empty($instance['maplong']) ? '' : $instance['maplong'];
        $mapzoom = empty($instance['mapzoom']) ? '' : $instance['mapzoom'];
        $adresse = empty($instance['adresse']) ? '' : $instance['adresse'];
        $img_bg = empty($instance['img_bg']) ? '' : $instance['img_bg'];
        ?>
        <style scoped>

            .about-cover {
                background: linear-gradient(rgba(43, 48, 59, 0.75), rgba(43, 48, 59, 0.75)), url(<?php echo esc_url($img_bg); ?>) no-repeat;
                background: -webkit-linear-gradient(rgba(43, 48, 59, 0.75), rgba(43, 48, 59, 0.75)), url(<?php echo esc_url($img_bg); ?>) no-repeat;
                background-size: 100%;
                height: 265px;
                position: relative;
            }
            #cd-zoom-in,
            #cd-zoom-out {
                background-image: url("<?php echo esc_url(get_template_directory_uri()); ?>/images/gmaps/cd-icon-controller.svg");
            }

        </style>
        <script>
            jQuery(document).ready(function ($) {


                var menu_trigger = $("[data-card-front]");
                var back_trigger = $("[data-card-back]");

                menu_trigger.on('click', function () {
                    $(".about-card").removeClass("show-menu");
                });

                back_trigger.on('click', function () {
                    $(".about-card").addClass("show-menu");
                });

        <?php if (!empty($maplati) and ! empty($maplong) and ! empty($mapzoom)) { ?>
                    $(".map-location").one('click', function () {
                        //set your google maps parameters
                        var latitude = <?php echo esc_js($maplati); ?>,
                                longitude = <?php echo esc_js($maplong); ?>,
                                map_zoom = <?php echo esc_js($mapzoom); ?>;

                        //google map custom marker icon - .png fallback for IE11
                        var is_internetExplorer11 = navigator.userAgent.toLowerCase().indexOf('trident') > -1;
                        var marker_url = (is_internetExplorer11) ? '<?php echo esc_url(get_template_directory_uri()); ?>/images/gmaps/cd-icon-location.png' : '<?php echo esc_url(get_template_directory_uri()); ?>/images/gmaps/cd-icon-location.svg';

                        //define the basic color of your map, plus a value for saturation and brightness
                        var main_color = '#2d313f',
                                saturation_value = -20,
                                brightness_value = 5;

                        //we define here the style of the map
                        var style = [{
                                "featureType": "landscape",
                                "elementType": "labels",
                                "stylers": [{
                                        "visibility": "off"
                                    }]
                            }, {
                                "featureType": "transit",
                                "elementType": "labels",
                                "stylers": [{
                                        "visibility": "off"
                                    }]
                            }, {
                                "featureType": "poi",
                                "elementType": "labels",
                                "stylers": [{
                                        "visibility": "off"
                                    }]
                            }, {
                                "featureType": "water",
                                "elementType": "labels",
                                "stylers": [{
                                        "visibility": "off"
                                    }]
                            }, {
                                "featureType": "road",
                                "elementType": "labels.icon",
                                "stylers": [{
                                        "visibility": "off"
                                    }]
                            }, {
                                "stylers": [{
                                        "hue": "#00aaff"
                                    }, {
                                        "saturation": -100
                                    }, {
                                        "gamma": 2.15
                                    }, {
                                        "lightness": 12
                                    }]
                            }, {
                                "featureType": "road",
                                "elementType": "labels.text.fill",
                                "stylers": [{
                                        "visibility": "on"
                                    }, {
                                        "lightness": 24
                                    }]
                            }, {
                                "featureType": "road",
                                "elementType": "geometry",
                                "stylers": [{
                                        "lightness": 57
                                    }]
                            }];

                        //set google map options
                        var map_options = {
                            center: new google.maps.LatLng(latitude, longitude),
                            zoom: map_zoom,
                            panControl: false,
                            zoomControl: false,
                            mapTypeControl: false,
                            streetViewControl: false,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            scrollwheel: false,
                            styles: style
                        };
                        //inizialize the map
                        var map = new google.maps.Map(document.getElementById('google-container'), map_options);
                        //add a custom marker to the map                
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(latitude, longitude),
                            map: map,
                            visible: true,
                            icon: marker_url
                        });

                        //add custom buttons for the zoom-in/zoom-out on the map
                        function CustomZoomControl(controlDiv, map) {
                            //grap the zoom elements from the DOM and insert them in the map 
                            var controlUIzoomIn = document.getElementById('cd-zoom-in'),
                                    controlUIzoomOut = document.getElementById('cd-zoom-out');
                            controlDiv.appendChild(controlUIzoomIn);
                            controlDiv.appendChild(controlUIzoomOut);

                            // Setup the click event listeners and zoom-in or out according to the clicked element
                            google.maps.event.addDomListener(controlUIzoomIn, 'click', function () {
                                map.setZoom(map.getZoom() + 1);
                            });
                            google.maps.event.addDomListener(controlUIzoomOut, 'click', function () {
                                map.setZoom(map.getZoom() - 1);
                            });
                        }

                        var zoomControlDiv = document.createElement('div');
                        var zoomControl = new CustomZoomControl(zoomControlDiv, map);

                        //insert the zoom div on the top left of the map
                        map.controls[google.maps.ControlPosition.LEFT_TOP].push(zoomControlDiv);
                    });
        <?php } ?>
            });

        </script>
       <!-- --><?php
/*        if (!empty($title)) {
            echo '<span class="content-title">' . $title . '</span>';
        }*/
        ?>
        <div class="about-card">
            <div class="face2 card-face">
                <div id="cd-google-map">
                    <div id="google-container"></div>
                    <div id="cd-zoom-in"></div>
                    <div id="cd-zoom-out"></div>
                    <address><?php echo esc_html($adresse); ?></address>
                    <div class="back-cover" data-card-back="data-card-back"><i class="fa fa-long-arrow-left"></i>
                    </div>
                </div>
            </div>
            <div class="face1 card-face">
                <div class="about-cover card-face">
                    <?php if (!empty($maplati) and ! empty($maplong)) { ?>
                        <a class="map-location" data-card-front="data-card-front"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/map-icon.png" alt="">
                        </a>
                        <?php } ?>
                    <div class="about-details">
                        <?php if (!empty($mymail)) { ?>
                            <div><span class="fa fa-inbox"></span><span class="detail"><?php echo esc_html($mymail); ?></span>
                            </div>
        <?php } ?>
                        <?php if (!empty($mytel)) { ?>
                            <div><span class="fa fa-phone"></span><span class="detail"><?php echo esc_html($mytel); ?></span>
                            </div>
        <?php } ?>
                    </div>

                    <div class="cover-content-wrapper">
                        <?php if (!empty($mydescription)) { ?>
                            <span class="about-description"><?php echo esc_html($mydescription); ?></span>
                        <?php } ?>
                        <?php
                        if ($freelance == 'YES') {
                            echo '<span class="status">';
                            echo '<span class="fa fa-circle"></span>';
                            echo '<span class="text">'. esc_html__('Available as', 'pulse') .' <strong>'.esc_html__('freelance', 'pulse').'</strong></span>';
                            echo '</span>';
                        }
                        ?>
                    </div>
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
        // outputs the options form on admin

        //$title = empty($instance['title']) ? '' : $instance['title'];
        $mymail = empty($instance['mymail']) ? '' : $instance['mymail'];
        $mytel = empty($instance['mytel']) ? '' : $instance['mytel'];
        $mydescription = empty($instance['mydescription']) ? '' : $instance['mydescription'];
        $freelance = empty($instance['freelance']) ? 'NO' : $instance['freelance'];
        $maplati = empty($instance['maplati']) ? '' : $instance['maplati'];
        $maplong = empty($instance['maplong']) ? '' : $instance['maplong'];
        $mapzoom = empty($instance['mapzoom']) ? '' : $instance['mapzoom'];
        $adresse = empty($instance['adresse']) ? '' : $instance['adresse'];
        $img_bg = empty($instance['img_bg']) ? '' : $instance['img_bg'];
        ?>
        <strong><h2>PERSONAL DETAILS</h2></strong>

        <p>
            <label for="<?php echo esc_attr($this->get_field_name('mymail')); ?>"><?php esc_html_e('Mail:', 'pulse');?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('mymail')); ?>" name="<?php echo esc_attr($this->get_field_name('mymail')); ?>" type="text" value="<?php echo esc_attr($mymail); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('mytel')); ?>"><?php esc_html_e(' Tel:','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('mytel')); ?>" name="<?php echo esc_attr($this->get_field_name('mytel')); ?>" type="text" value="<?php echo esc_attr($mytel); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('mydescription')); ?>"><?php esc_html_e(' Description:','pulse'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('mydescription')); ?>" name="<?php echo esc_attr($this->get_field_name('mydescription')); ?>"><?php echo esc_attr($mydescription); ?></textarea>
        </p>
        <p>
        <p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('freelance')); ?>"><?php esc_html_e(' Available as freelance :','pulse'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('freelance')); ?>" name="<?php echo esc_attr($this->get_field_name('freelance')); ?>" class="widefat" style="width:100%;">
                <option <?php selected($freelance, 'YES'); ?> value="YES"><?php esc_html_e('YES','pulse') ?></option>
                <option <?php selected($freelance, 'NO'); ?> value="NO"><?php esc_html_e('NO','pulse') ?></option>   
            </select> 
        </p>
        <hr>
        <strong><h2>GOOGLE MAPS</h2></strong>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('maplati')); ?>"><?php esc_html_e('Google maps latitude:','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('maplati')); ?>" name="<?php echo esc_attr($this->get_field_name('maplati')); ?>" type="text" value="<?php echo esc_attr($maplati); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('maplong')); ?>"><?php esc_html_e('Google maps longitude:','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('maplong')); ?>" name="<?php echo esc_attr($this->get_field_name('maplong')); ?>" type="text" value="<?php echo esc_attr($maplong); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('mapzoom')); ?>"><?php esc_html_e('Google maps zoom (between 1 and 25):','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('mapzoom')); ?>" name="<?php echo esc_attr($this->get_field_name('mapzoom')); ?>" type="text" value="<?php echo esc_attr($mapzoom); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('adresse ')); ?>"><?php esc_html_e(' Adress:','pulse'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('adresse')); ?>" name="<?php echo esc_attr($this->get_field_name('adresse')); ?>" type="text" value="<?php echo esc_attr($adresse); ?>" />
        </p>
        <hr>
        <strong><h2>BACKGROUND IMAGE</h2></strong>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('img_bg')); ?>"><?php esc_html_e('Add/Edit image : ','pulse'); ?></label><br>
            <input id="urlpic" type="hidden" name="<?php echo esc_attr($this->get_field_name('img_bg')); ?>" id="<?php echo esc_attr($this->get_field_id('img_bg')); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url($img_bg); ?>" />
            <input class="upload_image_bio" type="image" value="<?php esc_html_e("Upload Image","pulse"); ?>" src="<?php echo esc_url($img_bg); ?>" width="200px" height="100px"/>
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

        //$instance['title'] = strip_tags($new_instance['title']);
        $instance['mymail'] = strip_tags($new_instance['mymail']);
        $instance['mytel'] = strip_tags($new_instance['mytel']);
        $instance['mydescription'] = strip_tags($new_instance['mydescription']);
        $instance['freelance'] = $new_instance['freelance'];
        $instance['maplati'] = strip_tags($new_instance['maplati']);
        $instance['maplong'] = strip_tags($new_instance['maplong']);
        $instance['mapzoom'] = strip_tags($new_instance['mapzoom']);
        $instance['adresse'] = strip_tags($new_instance['adresse']);
        $instance['img_bg'] = strip_tags($new_instance['img_bg']);
        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('about_toggle_widget');
});

