<?php

class research_projects extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_args = array(
            'description' => 'PULSE RESEARCH PROJECTS'
        );
        parent::__construct('pulse_research_projects', 'PULSE RESEARCH PROJECTS', $widget_args);
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
        $resprojects = isset( $instance['resprojects'] ) ? $instance['resprojects'] : array();

?>

                        <div class="slide-wrapper slide_wrapper<?php echo esc_attr($args['widget_id']); ?>">
                            <nav class="res_nav">
                                <a class="fa fa-angle-left" id="btn-prev"></a>
                                <a class="fa fa-angle-right" id="btn-next"></a>

                            </nav>
                            <div class="slider-details">
                                <span class="slide-counter"></span>
                                <span class="slide-date"><i class="li_calendar"></i></span>
                            </div>
                            <?php foreach ($resprojects as $key => $resproject) {?>
                            <?php if($key == 0) { ?>
                            <div class="slide active" data-date="<?php echo esc_attr($resproject['researchdate']);  ?>">
                                <div class="slide-header">
                                    <h3><?php echo esc_html($resproject['projecttitle']);  ?></h3>
                                    <h4><?php echo esc_html($resproject['projectsubtitle']);  ?></h4>
                                </div>
                                <div class="slide-content">
                                    <?php echo balanceTags($resproject['projectcontent'],true);  ?>

                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="slide" data-date="<?php echo esc_attr($resproject['researchdate']);  ?>">
                                <div class="slide-header">
                                    <h3><?php echo esc_html($resproject['projecttitle']);  ?></h3>
                                    <h4><?php echo esc_html($resproject['projectsubtitle']);  ?></h4>
                                </div>
                                <div class="slide-content">
                                    <?php echo balanceTags($resproject['projectcontent'],true);  ?>
                                </div>
                            </div>
                             <?php }  ?>
                             <?php } ?>
                        </div>
<script>
    jQuery(document).ready(function($) {
        
   
        // Variables
    var currentSlide = 1,
        currentDate = $('.slide_wrapper<?php echo esc_html($args['widget_id']); ?> .active').data("date"),
        slideName = $('.slide_wrapper<?php echo esc_html($args['widget_id']); ?> div.slide'),
        totalSlides = slideName.length,
        slideCounter = $('.slide_wrapper<?php echo esc_html($args['widget_id']); ?> .slide-counter'),
        sliderDate = $('.slide_wrapper<?php echo esc_html($args['widget_id']); ?> .slide-date'),
        btnNext = $('.slide_wrapper<?php echo esc_html($args['widget_id']); ?> a#btn-next'),
        btnPrev = $('.slide_wrapper<?php echo esc_html($args['widget_id']); ?> a#btn-prev'),
        addSlide = $('.slide_wrapper<?php echo esc_html($args['widget_id']); ?> a#add-slide');

    slideCounter.text(currentSlide + ' / ' + totalSlides);
    sliderDate.html('<span class="research-date-label"><i class="fa fa-calendar"></i></span>' + currentDate);
    // Slide Transitions
    function btnTransition(button, direction) {
        $(button).on('click', function() {

            if (button === btnNext && currentSlide >= totalSlides) {
                currentSlide = 1;
            } else if (button === btnPrev && currentSlide === 1) {
                currentSlide = totalSlides;
            } else {
                direction();
            };
            currentDate = $(slideName).eq(currentSlide - 1).data("date");
            slideName.filter('.active').animate({
                opacity: 0,
                left: -40
            }, 400, function() {
                $(this)
                    .removeClass('active')
                    .css('left', 0);
                $(slideName)
                    .eq(currentSlide - 1)
                    .css({
                        'opacity': 0,
                        'left': 40
                    })
                    .addClass('active')
                    .animate({
                        opacity: 1,
                        left: 0
                    }, 400);
            });

            slideCounter.text(currentSlide + ' / ' + totalSlides);
            sliderDate.html('<span class="research-date-label"><i class="fa fa-calendar"></i></span>' + currentDate);
        });
    };
    // Slide forward
    btnTransition(btnNext, function() {
        currentSlide++;
    });
    // Slide Backwards
    btnTransition(btnPrev, function() {
        currentSlide--;
    });
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


        $resprojects = isset($instance['resprojects']) ? $instance['resprojects'] : array();
        $resprojects_num = count($resprojects);
        $resprojects[$resprojects_num + 1] = '';
        $resprojects_html = array();
        $resprojects_counter = 0;


        foreach ($resprojects as $resproject) {
            if (isset($resproject['researchdate']) || isset($resproject['projecttitle']) || isset($resproject['projectsubtitle']) || isset($resproject['projectcontent'])) {
                $resprojects_html[] = sprintf(
                        '<div style="background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;"><p>
                     <label for="">Research Date</label>
                     <input class="widefat" id="" name="%1$s[%2$s][researchdate]" type="text" value="%3$s" />
                     </p>
                     
                     <p>
                     <label for="">Project title</label>
                     <input class="widefat" id="" name="%1$s[%2$s][projecttitle]" type="text" value="%4$s" />
                     </p>
                     
                    <p>
                     <label for="">Project subtitle</label>
                     <input class="widefat" id="" name="%1$s[%2$s][projectsubtitle]" type="text" value="%5$s" />
                     </p>
                     
                    <p>
                        <label for="">Project description</label>
                        <textarea class="widefat" id="" name="%1$s[%2$s][projectcontent]">%6$s</textarea>
                    </p>
                    
                    <span class="remove-field button button-primary button-large">Remove Project</span></div>
                    ', $this->get_field_name('resprojects')
                        , $resprojects_counter
                        , esc_attr($resproject['researchdate'])
                        , esc_attr($resproject['projecttitle'])
                        , esc_attr($resproject['projectsubtitle'])
                        , esc_attr($resproject['projectcontent'])
                );
            }


            $resprojects_counter += 1;
        }
        print '<strong><h2>Research Projects</h2></strong>' . join($resprojects_html);
        ?>
        <script type="text/javascript" >
           
            var myfieldname = <?php echo json_encode($this->get_field_name('resprojects')) ?>;
            var myfieldnum = <?php echo json_encode($resprojects_counter-1) ?>;
                        jQuery(function ($) {
                var count = myfieldnum;

                $('.<?php echo esc_html($this->get_field_id('add_field')); ?>').click(function () {

                    $("#<?php echo esc_html($this->get_field_id('field_clone')); ?>").append("<div style='background-color: rgba(0,0,0,0.03);padding: 10px; border: 1px solid rgba(0,0,0,0.1);margin-bottom: 10px;'><p><label for=''>Research date</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][researchdate]' type='text' value='' /></p><p><label for=''>Project title</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][projecttitle]' type='text' value='' /></p><p><label for=''>Project subtitle</label><input class='widefat' name='" + myfieldname + "[" + (count + 1) + "][projectsubtitle]' type='text' value='' /></p><p><label for=''>Project description</label><textarea class='widefat' id='' name='" + myfieldname + "[" + (count + 1) + "][projectcontent]'></textarea></p><span class='remove-field button button-primary button-large'>Remove project</span></div>");
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
        echo '<input class="button ' . $this->get_field_id('add_field') . ' button-primary button-large" type="button" value="Add project" id="add_field" />';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance) {
         $instance = $old_instance;


        $instance['resprojects'] = array();

        if (isset($new_instance['resprojects'])) {
            foreach ($new_instance['resprojects'] as $resproject) {

                $instance['resprojects'][] = $resproject;
            }
        }

        return $instance;

    }

}

add_action('widgets_init', function() {
    register_widget('research_projects');
});
