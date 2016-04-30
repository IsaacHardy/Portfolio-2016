<?php
/*
  Template Name: Pulse one page
 */
$this_page = $post->ID;
get_header();
?>

<div class="hs-content-scroller">
 <?php if (ot_get_option('pulse_arrow') == 'on') { ?>
    <div class="arrow-prev"><a href="" class="previous-page arrow"><i class="fa fa-angle-left"></i></a></div>
    <div class="arrow-next"><a href="" class="next-page arrow"><i class="fa fa-angle-right"></i></a></div>
    <?php } ?>
    <!-- Header -->
    <div id="header_container">
        <div id="header">
            <div class="header_but">
                <div><a class="homesection"><i class="fa fa-home"></i></a>
            </div>
            </div>
            <div class="aside1">
                <?php
                    if(ot_get_option( 'contact_on_off' ) == 'on' ) {
                        echo '<a class="contact-button"><i class="fa fa-paper-plane"></i>Contact</a>';
                    }
                ?>
                    
                <?php if (!null == ot_get_option( 'cv_attachment_id' )) { ?>
                    <a class="download-button" href="<?php echo esc_url(ot_get_option( 'cv_attachment_id' )) ; ?>"><i class="fa fa-cloud-download"></i>PDF</a>
                <?php } ?>
                <div class="aside-content"><span class="part1"><?php echo ot_get_option( 'sidebar_text1' ); ?></span><span class="part2"><?php echo ot_get_option( 'sidebar_text2' ); ?></span>
                </div>

            </div>
            
            <!-- News scroll
            <!-- <?php
            $news_items = ot_get_option('header_news', array());
            if (!empty($news_items)) {
                ?>
                <div class="news-scroll">
                    <?php echo '<span><i class="fa fa-line-chart"></i>'.esc_html__('RECENT ACTIVITY', 'pulse').'</span>' ?>
                    <ul id="marquee" class="marquee">
                        <?php
                        foreach ($news_items as $news_item) {

                            echo '<li><strong class="marque-tit">' . $news_item['title'] . '</strong>' . $news_item['header_news_content'] . '</li>';
                        }
                        ?>


                    </ul>
                </div>
            <?php } ?> -->
            <!-- End News scroll -->
        </div> 
    </div>
    <!-- End Header -->
    <!-- hs-content-wrapper -->
    <div class="hs-content-wrapper">
        <?php
        $args = array('order' => 'ASC',
            'orderby' => 'menu_order',
            'post_type' => 'page',
            'post__not_in' => array($this_page),
            'posts_per_page' => -1,
        );
        $the_query = new WP_Query($args);

// The Loop
        if ($the_query->have_posts()) :

            while ($the_query->have_posts()) : $the_query->the_post();
                $the_sub_query = new WP_Query(array('page_id' => $the_query->post->ID));
                if ($the_sub_query->is_posts_page) {
                    continue;
                }
                $mytemplate = get_post_meta($the_query->post->ID, '_wp_page_template', true);
                $title = $the_query->post->post_title;
                echo "<article class='hs-content' id='section" . $the_query->post->menu_order . "'>";
                echo "<span class='sec-icon fa " . get_post_meta($the_query->post->ID, 'iconfont-select', true) . "'></span>";
                echo "<div class='hs-inner'>";
                echo "<span class='before-title'>.0" . $the_query->post->menu_order . "</span>";
                echo "<h2 class='mainpage_title'>$title</h2>";
                if ($mytemplate != null) {
                    the_content();
                    get_template_part(substr($mytemplate, 0, -4));
                } else {
                    the_content();
                }
                echo "</div>";
                echo "</article>";

            endwhile;
        endif;

// Reset Post Data
        wp_reset_postdata();
        ?>
    </div>
    <!-- End hs-content-wrapper -->
</div>
<!-- End hs-content-scroller -->
<?php get_footer(); ?>
