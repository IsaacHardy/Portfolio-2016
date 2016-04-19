<?php

class ourteam extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE OUR TEAM'
        );
        parent::__construct('pulse_outeam', 'PULSE OUR TEAM', $widget_args);
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
        $ourteams = isset($instance['ourteams']) ? $instance['ourteams'] : array();
        ?>
        <div class="team_wrapper row">
        <?php foreach ($ourteams as $ourteam) { ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6
                 teamcol">
                <div class="team-card-container">
                    <div class="card">
                        <div class="front" style="z-index: 2;background: linear-gradient(rgba(43, 48, 59, 0.8), rgba(43, 48, 59, 0.8)), url(<?php echo esc_url($ourteam['teampic']) ?>);background: -webkit-linear-gradient(rgba(43, 48, 59, 0.8), rgba(43, 48, 59, 0.8)), url(<?php echo esc_url($ourteam['teampic']) ?>);     background-size: cover; background-repeat: no-repeat;background-position: center center;">
                            <div class="front-detail">
                                <h4><?php echo esc_html($ourteam['name']); ?></h4>
                                <h3><?php echo esc_html($ourteam['profession']); ?></h3>
                            </div>
                        </div>
                        <div class="back">
                            <div class="social-icons">
                                <?php
                                if (!empty($ourteam['email'])) {
                                    echo '<a href="mailto:' . esc_url($ourteam['email'])  . '"><i class="fa fa-envelope"></i></a>';
                                }
                                if (!empty($ourteam['facebook'])) {
                                    echo '<a href="' . esc_url($ourteam['facebook'])  . '" target="_blank" ><i class="fa fa-facebook"></i></a>';
                                }
                                if (!empty($ourteam['twitter'])) {
                                    echo '<a href="' . esc_url($ourteam['twitter'])  . '" target="_blank" ><i class="fa fa-twitter"></i></a>';
                                }
                                if (!empty($ourteam['googleplus'])) {
                                    echo '<a href="' . esc_url($ourteam['googleplus'])  . '" target="_blank" ><i class="fa fa-google-plus"></i></a>';
                                }
                                if (!empty($ourteam['youtube'])) {
                                    echo '<a href="' . esc_url($ourteam['youtube'])  . '" target="_blank" ><i class="fa fa-youtube"></i></a>';
                                }
                                if (!empty($ourteam['linkedin'])) {
                                    echo '<a href="' . esc_url($ourteam['linkedin'])  . '" target="_blank" ><i class="fa fa-linkedin"></i></a>';
                                }
                                if (!empty($ourteam['flickr'])) {
                                    echo '<a href="' . esc_url($ourteam['flickr'])  . '" target="_blank" ><i class="fa fa-flickr"></i></a>';
                                }
                                if (!empty($ourteam['dribbble'])) {
                                    echo '<a href="' . esc_url($ourteam['dribbble'])  . '" target="_blank" ><i class="fa fa-dribbble"></i></a>';
                                }
                                if (!empty($ourteam['instagram'])) {
                                    echo '<a href="' . esc_url($ourteam['instagram'])  . '" target="_blank" ><i class="fa fa-instagram"></i></a>';
                                }
                                if (!empty($ourteam['github'])) {
                                    echo '<a href="' . esc_url($ourteam['github'])  . '" target="_blank" ><i class="fa fa-github-alt"></i></a>';
                                }
                                if (!empty($ourteam['vimeo'])) {
                                    echo '<a href="' . esc_url($ourteam['vimeo'])  . '" target="_blank" ><i class="fa fa-vimeo-square"></i></a>';
                                }
                                if (!empty($ourteam['vk'])) {
                                    echo '<a href="' . esc_url($ourteam['vk'])  . '" target="_blank" ><i class="fa fa-vk"></i></a>';
                                }
                                if (!empty($ourteam['foursquare'])) {
                                    echo '<a href="' . esc_url($ourteam['foursquare'])  . '" target="_blank" ><i class="fa fa-foursquare"></i></a>';
                                }
                                if (!empty($ourteam['tumblr'])) {
                                    echo '<a href="' . esc_url($ourteam['tumblr'])  . '" target="_blank" ><i class="fa fa-tumblr"></i></a>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                </div>
        <?php } ?>

        </div>
        <script type="text/javascript">
           jQuery(document).ready(function($) {
            if ($('.hs-content').width() < 600) {
                $( ".team_wrapper .teamcol" ).removeClass('col-md-4');
                $( ".team_wrapper .teamcol" ).addClass('col-md-6');
                $( ".team_wrapper .teamcol" ).removeClass('col-lg-4');
                $( ".team_wrapper .teamcol" ).addClass('col-lg-6');

            };

           });

        </script>


        <?php
        echo wp_kses_post($args['after_widget']);
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance) {


        $ourteams = isset($instance['ourteams']) ? $instance['ourteams'] : array();
        $ourteams_num = count($ourteams);
        $ourteams[$ourteams_num + 1] = '';
        $ourteams_html = array();
        $ourteams_counter = 0;

        foreach ($ourteams as $ourteam) {
            if (!empty($ourteam)) {
                $ourteams_html[] = sprintf(
                        '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">Name</label>
                     <input class="widefat" id="" name="%1$s[%2$s][name]" type="text" value="%3$s" />
                     </p>
                     
                     <p>
                     <label for="">Profession</label>
                     <input class="widefat" id="" name="%1$s[%2$s][profession]" type="text" value="%4$s" />
                     </p>
                     
                    <p>
                        <label for="">Email</label>
                        <input class="widefat" id="" name="%1$s[%2$s][email]" type="text" value="%5$s" />
                    </p>
                    
                    <p>
                    <label for="">Member picture</label>
                    <input id="urlteampic" name="%1$s[%2$s][teampic]"  class="widefat" type="text" size="36"  value="%6$s" />
                    <input class="button button-primary button-large upload_ourteam" type="button" value="Upload member picture"/>
   
                     </p>
                     <label for="">Facebook</label>
                     <input class="widefat" id="" name="%1$s[%2$s][facebook]" type="text" value="%7$s" />
                     </p>
                     
                     </p>
                     <label for="">Twitter</label>
                     <input class="widefat" id="" name="%1$s[%2$s][twitter]" type="text" value="%8$s" />
                     </p>
                     
                     </p>
                     <label for="">Google plus</label>
                     <input class="widefat" id="" name="%1$s[%2$s][googleplus]" type="text" value="%9$s" />
                     </p>
                     
                     </p>
                     <label for="">Youtube</label>
                     <input class="widefat" id="" name="%1$s[%2$s][youtube]" type="text" value="%10$s" />
                     </p>
                     
                     </p>
                     <label for="">Linkedin</label>
                     <input class="widefat" id="" name="%1$s[%2$s][linkedin]" type="text" value="%11$s" />
                     </p>
                     
                     </p>
                     <label for="">Flickr</label>
                     <input class="widefat" id="" name="%1$s[%2$s][flickr]" type="text" value="%12$s" />
                     </p>
                     
                     </p>
                     <label for="">Dribbble</label>
                     <input class="widefat" id="" name="%1$s[%2$s][dribbble]" type="text" value="%13$s" />
                     </p>
                     
                     </p>
                     <label for="">Instagram</label>
                     <input class="widefat" id="" name="%1$s[%2$s][instagram]" type="text" value="%14$s" />
                     </p>
                     
                     </p>
                     <label for="">Github</label>
                     <input class="widefat" id="" name="%1$s[%2$s][github]" type="text" value="%15$s" />
                     </p>
                     
                     </p>
                     <label for="">Vimeo</label>
                     <input class="widefat" id="" name="%1$s[%2$s][vimeo]" type="text" value="%16$s" />
                     </p>
                     
                     </p>
                     <label for="">Vk</label>
                     <input class="widefat" id="" name="%1$s[%2$s][vk]" type="text" value="%17$s" />
                     </p>
                     
                     </p>
                     <label for="">Foursquare</label>
                     <input class="widefat" id="" name="%1$s[%2$s][foursquare]" type="text" value="%18$s" />
                     </p>
                     
                     </p>
                     <label for="">Tumblr</label>
                     <input class="widefat" id="" name="%1$s[%2$s][tumblr]" type="text" value="%19$s" />
                     </p>

                     
                    

                    <span class="remove-field button button-primary button-large">Remove Member</span></div>
                    ', $this->get_field_name('ourteams')
                        , $ourteams_counter
                        , esc_attr($ourteam['name'])
                        , esc_attr($ourteam['profession'])
                        , esc_attr($ourteam['email'])
                        , esc_attr($ourteam['teampic'])
                        , esc_attr($ourteam['facebook'])
                        , esc_attr($ourteam['twitter'])
                        , esc_attr($ourteam['googleplus'])
                        , esc_attr($ourteam['youtube'])
                        , esc_attr($ourteam['linkedin'])
                        , esc_attr($ourteam['flickr'])
                        , esc_attr($ourteam['dribbble'])
                        , esc_attr($ourteam['instagram'])
                        , esc_attr($ourteam['github'])
                        , esc_attr($ourteam['vimeo'])
                        , esc_attr($ourteam['vk'])
                        , esc_attr($ourteam['foursquare'])
                        , esc_attr($ourteam['tumblr'])
                );
            }


            $ourteams_counter += 1;
        }
        print '<strong><h2>Team Members</h2></strong>' . join($ourteams_html);
        ?>
        <script type="text/javascript" >

            var myfieldname = <?php echo json_encode($this->get_field_name('ourteams')) ?>;
            var myfieldnum = <?php echo json_encode($ourteams_counter - 1) ?>;
            jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'>\n\
            <p><label for=''>Name</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][name]' type='text' value='' /></p>\n\
            <p><label for=''>Profession</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][profession]' type='text' value='' /></p>\n\
            <p><label for=''>Email</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][email]' type='text' value='' /></p>\n\
            <p><label for=''>Member picture</label><input id='urlteampic' class='widefat' name='" + myfieldname + "[" + (count + 1) + "][teampic]' type='text' value='' /><input class='button button-primary button-large upload_ourteam' type='button' value='Upload member picture'/></p>\n\
            <p><label for=''>Facebook</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][facebook]' type='text' value='' /></p>\n\
            <p><label for=''>Twitter</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][twitter]' type='text' value='' /></p>\n\
            <p><label for=''>Google plus</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][googleplus]' type='text' value='' /></p>\n\
            <p><label for=''>Youtube</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][youtube]' type='text' value='' /></p>\n\
            <p><label for=''>Linkedin</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][linkedin]' type='text' value='' /></p>\n\
            <p><label for=''>Flickr</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][flickr]' type='text' value='' /></p>\n\
            <p><label for=''>Dribbble</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][dribbble]' type='text' value='' /></p>\n\
            <p><label for=''>Instagram</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][instagram]' type='text' value='' /></p>\n\
            <p><label for=''>Github</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][github]' type='text' value='' /></p>\n\
            <p><label for=''>Vimeo</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][vimeo]' type='text' value='' /></p>\n\
            <p><label for=''>Vk</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][vk]' type='text' value='' /></p>\n\
            <p><label for=''>Foursquare</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][foursquare]' type='text' value='' /></p>\n\
            <p><label for=''>Tumblr</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][tumblr]' type='text' value='' /></p>\n\
            <span class='remove-field button button-primary button-large'>Remove Member</span></div>");
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
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add Member" id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['ourteams'] = array();

        if (isset($new_instance['ourteams'])) {
            foreach ($new_instance['ourteams'] as $ourteam) {

                $instance['ourteams'][] = $ourteam;
            }
        }

        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('ourteam');
});

