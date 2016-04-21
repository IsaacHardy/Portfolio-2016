<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package pulse
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <noscript>
        <style>
            @media screen and (max-width: 755px) {
                .hs-content-scroller {
                    overflow: visible;
                }
            }
        </style>
        </noscript>
        <?php wp_head(); ?>
    </head>

<body <?php body_class(); ?>>
    <div id="page-loader">
        <canvas id="demo-canvas"></canvas>
    </div>
    <div id="hs-container" class="hs-container">
        
                <aside class="hs-menu" id="hs-menu">
            <!-- <canvas id="demo-canvas"></canvas> -->

            <!-- Profil Image-->
            <div class="hs-headline">
                <a id="my-link" href="#my-panel"><i class="fa fa-bars"></i></a>
                <a href="<?php echo esc_url(ot_get_option( 'cv_attachment_id' )) ; ?>" class="download"><i class="fa fa-cloud-download"></i></a>
                <div class="img-wrap">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url(ot_get_option( 'perso_pic_upload' )) ; ?>" alt="<?php echo esc_attr(ot_get_option( 'my_name' )) ; ?>" width="150" height="150" /></a>
                </div>
                <div class="profile_info">
                    <h1><?php echo ot_get_option( 'my_name' ); ?></h1>
                    <h4><?php echo ot_get_option( 'my_subtitle' ); ?></h4>
                    <?php if (!null == ot_get_option( 'my_location' )) { ?>
                    <h6><span class="fa fa-location-arrow"></span>&nbsp;&nbsp;&nbsp;<?php echo ot_get_option( 'my_location' ); ?></h6>
                    <?php } ?>
                </div>
                <div style="clear:both"></div>
            </div>
            <div class="separator-aside"></div>
            <!-- End Profil Image-->

            <!-- menu -->
            <?php if ( has_nav_menu( 'primary' ) and has_nav_menu( 'onepage_menu' ) ) { ?>
                        <?php if (basename( get_page_template(),".php" ) == 'page-all') { ?>
            <nav>
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 
                                          'menu_class' => 'nav',
                                          'walker' => new pulse_mywalker(),
                                          'before' => '',
                                          'after' => '',
                                          'container' => false,
                                          'items_wrap' => '%3$s',
                                          'depth' => 0,
                    ) ) ?>
            </nav>
            <?php } else { ?>
            
             <nav>
                <?php wp_nav_menu( array( 'theme_location' => 'onepage_menu', 
                                          'menu_class' => 'nav',
                                          'walker' => new pulse_mywalker2(),
                                          'before' => '',
                                          'after' => '',
                                          'container' => false,
                                          'items_wrap' => '%3$s',
                                          'depth' => 0,
                    ) ) ?>
            </nav>
            <?php } ?>

            <?php } ?>

            <!-- end menu-->
            <!-- social icons -->
            <div class="aside-footer">
                <?php
                if(ot_get_option( 'facebook_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'facebook_url' )) .'" target="_blank" ><i class="fa fa-facebook"></i></a>';
                }
                if(ot_get_option( 'twitter_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'twitter_url' )) .'" target="_blank" ><i class="fa fa-twitter"></i></a>';
                }
                if(ot_get_option( 'googleplus_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'googleplus_url' )) .'" target="_blank" ><i class="fa fa-google-plus"></i></a>';
                }
                if(ot_get_option( 'youtube_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'youtube_url' )) .'" target="_blank" ><i class="fa fa-youtube"></i></a>';
                }
                if(ot_get_option( 'linkedin_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'linkedin_url' )) .'" target="_blank" ><i class="fa fa-linkedin"></i></a>';
                }
                if(ot_get_option( 'flickr_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'flickr_url' )) .'" target="_blank" ><i class="fa fa-flickr"></i></a>';
                }
                if(ot_get_option( 'dribbble_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'dribbble_url' )) .'" target="_blank" ><i class="fa fa-dribbble"></i></a>';
                }
                if(ot_get_option( 'instagram_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'instagram_url' )) .'" target="_blank" ><i class="fa fa-instagram"></i></a>';
                }
                if(ot_get_option( 'github_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'github_url' )) .'" target="_blank" ><i class="fa fa-github-alt"></i></a>';
                }
                if(ot_get_option( 'vimeo_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'vimeo_url' )) .'" target="_blank" ><i class="fa fa-vimeo-square"></i></a>';
                }
                if(ot_get_option( 'vk_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'vk_url' )) .'" target="_blank" ><i class="fa fa-vk"></i></a>';
                }
                if(ot_get_option( 'foursquare_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'foursquare_url' )) .'" target="_blank" ><i class="fa fa-foursquare"></i></a>';
                }
                if(ot_get_option( 'tumblr_on_off' ) == 'on' ) {
                    echo '<a href="'. esc_url(ot_get_option( 'tumblr_url' )) .'" target="_blank" ><i class="fa fa-tumblr"></i></a>';
                }
                ?>
            </div>
            <!-- end social icons -->
        </aside>
                <!-- End sidebar -->

        <!-- Go To Top Button -->
        <a href="#hs-menu" class="hs-totop-link"><i class="fa fa-chevron-up"></i></a>
        <!-- End Go To Top Button -->



