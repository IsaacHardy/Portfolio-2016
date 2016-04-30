<?php

/**
 * pulse functions and definitions
 *
 * @package pulse
 */
/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter('ot_theme_mode', '__return_true');

/**
 * Required: include OptionTree.
 */
require( trailingslashit(get_template_directory()) . 'option-tree/ot-loader.php' );
/**
 * Loads Theme Options
 */
require( trailingslashit(get_template_directory()) . 'inc/theme-options.php' );

/**
 * * Hide the "new layout" on the theme option page
 */
add_filter('ot_show_new_layout', '__return_false');

/**
 * Hide the theme option settings and documentation pages
 */
//add_filter('ot_show_pages', '__return_false');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
    $content_width = 640; /* pixels */
}

if (!function_exists('pulse_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function pulse_setup() {
        add_editor_style();
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on pulse, use a find and replace
         * to change 'pulse' to the name of your theme in all the template files
         */
        load_theme_textdomain('pulse', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');



        if (function_exists('add_theme_support')) {
            add_theme_support('post-thumbnails');
        }

        /**
         * add images size
         */
        if (function_exists('add_image_size')) {
            add_image_size("pulse_mypost_image", 9999, 9999, false);
        }

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        //add_theme_support( 'post-thumbnails' );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary menu', 'pulse'),
            'onepage_menu' => esc_html__('Onepage menu', 'pulse'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'video', 'audio',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('pulse_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }

endif; // pulse_setup
add_action('after_setup_theme', 'pulse_setup');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function pulse_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'pulse'),
        'id' => 'sidebar-1',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));
}

add_action('widgets_init', 'pulse_widgets_init');

/**
 * Enqueue Google font.
 */
    function pulse_font_url()  { 
        $fonts_url = '';
        $font_families = array();
        $font_families[] = 'Titillium Web:100,400,200,300,600,700,900';
        if (ot_get_option('pulse_body_font') != 'none' && !null == ot_get_option('pulse_body_font')) {
            $font_families[] = str_replace('+', ' ', ot_get_option('pulse_body_font')).':100,200,300,400,600,700,900';
        }
        if (ot_get_option('pulse_heading_font') != 'none' && !null == ot_get_option('pulse_heading_font')) {
            $font_families[] = str_replace('+', ' ', ot_get_option('pulse_heading_font')).':100,400,200,300,600,700,900';
        }
        $query_args = array(
           'family' => urlencode( implode( '|', $font_families ) ),
           'subset' => urlencode( 'latin,latin-ext' ),
        );
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        return esc_url_raw( $fonts_url );
 
    }
    function pulse_gfont() {
       wp_enqueue_style( 'theme-slug-fonts', pulse_font_url(), array(), null );
    }
    add_action( 'wp_enqueue_scripts', 'pulse_gfont' );

/**
 * Enqueue scripts and styles.
 */
function pulse_scripts() {
    wp_enqueue_style('style-css', get_stylesheet_uri());
    wp_enqueue_style('bootstrp-css', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style('normalize-css', get_template_directory_uri() . '/css/normalize.css');
    wp_enqueue_style('main-css-css', get_template_directory_uri() . '/css/main.css');
    wp_enqueue_script('bootsrap-css', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '20120206', true);



    wp_enqueue_script('default-js', get_template_directory_uri() . '/js/default.js', array('jquery'), '20130115', true);
    wp_enqueue_script('googlemaps-js', 'https://maps.googleapis.com/maps/api/js', array('jquery'), '20120206', true);
    wp_enqueue_script('watch-js', get_template_directory_uri() . '/js/watch.js', array('jquery'), '20130115', true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '20130115', true);
    wp_enqueue_script('navigation-js', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true);
    wp_enqueue_script('skip-link-focus-fix-js', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true);


    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'pulse_scripts');

function pulse_register_mediauploader() {
    wp_enqueue_script('script_admin_js', get_template_directory_uri() . '/js/meduploader.js');
}

add_action('admin_enqueue_scripts', 'pulse_register_mediauploader');

function pulse_register_admin_style() {
    wp_enqueue_style('style_admin_font', get_template_directory_uri() . '/css/font-awesome.min.css');
}

add_action('admin_print_styles', 'pulse_register_admin_style');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Include the TGM_Plugin.
 */
require_once get_template_directory() . '/tgm/tgm.php';
/**
 * Include the TGM_Plugin.
 */
require_once get_template_directory() . '/inc/theme-widgets.php';
/**
 * font-awesome-array.
 */
require get_template_directory() . '/inc/font-awesome-array/font-awesome-data.php';

/**
 * radium-one-click-demo-install
 */
function pulse_load_radium_one_click_demo_install() {
    require get_template_directory() . '/inc/radium-one-click-demo-install-master/init.php';
}

add_action('after_setup_theme', 'pulse_load_radium_one_click_demo_install', 2);

class pulse_mywalker extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $thispost = get_post($item->object_id);
        $menu_order = $thispost->menu_order;
        $meta_value = get_post_meta($item->object_id, 'iconfont-select', true);
        $the_query_blog = new WP_Query(array('page_id' => $item->object_id));
        if ($the_query_blog->is_posts_page) {
            $item_output = $args->before;
            $item_output .= '<a href="' . $item->url . '">';
            $item_output .= '<span class="menu_name" >' . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after . '</span>';
            $item_output .= '<span class="fa ' . $meta_value . '"></span>';
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        } else {
            $item_output = $args->before;
            $item_output .= '<a class="menu_reg" href="#section' . $menu_order . '">';
            $item_output .= '<span class="menu_name" >' . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after . '</span>';
            $item_output .= '<span class="fa ' . $meta_value . '"></span>';
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }
    function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0) {
     $output .= "";
  }

}

class pulse_mywalker2 extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $thispost = get_post($item->object_id);
        $menu_order = $thispost->menu_order;
        $meta_value = get_post_meta($item->object_id, 'iconfont-select', true);
        $the_query_blog = new WP_Query(array('page_id' => $item->object_id));
        if ($the_query_blog->is_posts_page) {
            $item_output = $args->before;
            $item_output .= '<a href="' . $item->url . '">';
            $item_output .= '<span class="menu_name" >' . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after . '</span>';
            $item_output .= '<span class="fa ' . $meta_value . '"></span>';
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        } else {
        	if ( 'posts' == get_option('show_on_front') ) {
        	$item_output = $args->before;
            $item_output .= '<a href="' . $item->url . '">';
            $item_output .= '<span class="menu_name" >' . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after . '</span>';
            $item_output .= '<span class="fa ' . $meta_value . '"></span>';
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

            } else {
            $item_output = $args->before;
            $item_output .= '<a href="' . get_site_url() . '/?section=' . $menu_order . '">';
            $item_output .= '<span class="menu_name" >' . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after . '</span>';
            $item_output .= '<span class="fa ' . $meta_value . '"></span>';
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            }
        }
    }
    function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0) {
     $output .= "";
  }

}

function pulse_custom_css() {
    $maincolor = '#0cc0c1';
    $style = '';
    if (!null == ot_get_option('main_colorpicker')) {
        $maincolor = ot_get_option('main_colorpicker');
    }
    $style .= '.hs-inner .mainpage_title:after , .singlepage-title:after {
    background: ' . $maincolor . ';
}
a.hs-totop-link {
    background: ' . $maincolor . ';
}
.hs-inner .before-title {
    color: ' . $maincolor . ';
}
.hs-menu nav .active-sec .fa {
    background: ' . $maincolor . ';
}
    .hs-headline .download{
background: ' . $maincolor . ';
    }
.aside1 a {
    color: ' . $maincolor . ';
}
.aside1 a:hover {
    background: ' . $maincolor . ';
}
.post-wrapper a {
    color: ' . $maincolor . ';
}
.aside1 .aside-content .part1 {
    color: ' . $maincolor . ';
}
#header .news-scroll span {
    color: ' . $maincolor . ';
}
.tabs-left > .nav-tabs > li > a {
    background: ' . $maincolor . ';
}
.tabs-left > .nav-tabs > li > a:hover, .tabs-left > .nav-tabs > li > a:focus {
    background: ' . $maincolor . ';
}
.tab-pane h4 {
    color: ' . $maincolor . ';
}
.resume > li > .resume-tag {
    background: ' . $maincolor . ';
}
.resume h4 {
    color: ' . $maincolor . ';
}
.bar-main-container {
    background: ' . $maincolor . ';
}
.publication_item .date {
    background: ' . $maincolor . ';
}
.media h4 {
    color: ' . $maincolor . ';
}
.label-pub {
    background: ' . $maincolor . ';
}
.publication-detail .ext_link {
    background: ' . $maincolor . ';
}
.publication-detail .ext_link:hover {
    color: ' . $maincolor . ';
}
.team-card-container h3 {
    color: ' . $maincolor . ';
}
.team-card-container .back .social-icons a {
    background: ' . $maincolor . ';
}
.slide-header h4 {
    color: ' . $maincolor . ';
}
.slider-details {
    background: ' . $maincolor . ';
}
.teaching-section .teaching > li > .teaching-tag {
    background: ' . $maincolor . ';
}
.teaching-section .teaching h4 {
    color: ' . $maincolor . ';
}
.work_desc .ext_link {
    background: ' . $maincolor . ';
}
.work_desc .ext_link:hover {
    color: ' . $maincolor . ';
}
.portfocount_container {
    background: ' . $maincolor . ';
}
.contact-section #contact_form .submit_btn:hover {
    color: ' . $maincolor . ';
    border: 1px solid ' . $maincolor . ';
}
.contact-section .contact_info h3 {
    color: ' . $maincolor . ';
}
.pace .pace-progress {
    background: ' . $maincolor . ';
}
.pricing-table-wrapper .pricing-table-header h3 {
  background: ' . $maincolor . ';
}
.proceess_wrap #progressbar li.active:before,  .proceess_wrap #progressbar li.active:after{
    background: ' . $maincolor . ';
}
.portfolio-wrapper figure .label {
   background: ' . $maincolor . ';
}
.blog-body .title-wrap h2 a , .blog-body .title-wrap h2 {
  color: ' . $maincolor . ';
}
.mypost_pagination_loop ul .current  {
 color: ' . $maincolor . ';
}
.service-section .serv-wrap .servicelistt ul li {
    background-color: ' . $maincolor . ';
}
.service-section .serv-wrap .serv-icons {
    background-color: ' . $maincolor . ';
}
.sticky .featured {
    border-top: 40px solid ' . $maincolor . ';
}
.verticaltab .nav-tabs.nav-tabs-left li a, .verticaltab .nav-tabs.nav-tabs-right li a {
    background: ' . $maincolor . ';
}
.post-container .btags a {
background: ' . $maincolor . ';
}
body {
    font-size: '.ot_get_option('glbl_size').'px;
}
.hs-inner .mainpage_title,
.singlepage-title {
    font-size: '.ot_get_option('sections_title').'px;
}
.content-title {
    font-size: '.ot_get_option('sml_title').'px;
}
.hs-menu nav a .menu_name {
    font-size: '.ot_get_option('menu_ftsize').'px;
}
@-webkit-keyframes pulse {
    0% {
        box-shadow: 0 0 0 .1em ' . $maincolor . ';
    }
    100% {
        box-shadow: 0 0 0 3em transparent;
    }
}
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 .1em ' . $maincolor . ';
    }
    100% {
        box-shadow: 0 0 0 3em transparent;
    }
}
#my-link {
    background: ' . $maincolor . ';
}';
    $sectionwidth = 700;
    $numberpage = (wp_count_posts('page')->publish) - 2;
    if (!null == ot_get_option('sectionwidth')) {
        $sectionwidth = ot_get_option('sectionwidth');
    }
    $contentwrap = (($sectionwidth + 10) * $numberpage ) + 10;
    $style .= '.hs-content-wrapper {
    width: ' . $contentwrap . 'px;
}

.hs-content {
    width: ' . $sectionwidth . 'px;
}';
    if (ot_get_option('pulse_loader') == 'off') {
        $style .= '#page-loader {
    display : none;
}';
    }

    echo '<style>' . $style . '</style>';
}

add_action('wp_head', 'pulse_custom_css');

/**
 * Include google font.
 */
if (!function_exists('pulse_custom_css2')) {

    function pulse_custom_css2() {
        $body_p_font = ot_get_option('pulse_body_font');
        if ($body_p_font != 'none') {
            $body_p_font = str_replace('+', ' ', $body_p_font);
            
            echo "<style>
            body {
    font-family: $body_p_font;
}
            </style>";
        }

        $heading_p_font = ot_get_option('pulse_heading_font');
        if ($heading_p_font != 'none') {
            $heading_p_font = str_replace('+', ' ', $heading_p_font);
            
            echo "<style>
            .hs-inner .mainpage_title,
            .hs-inner .before-title,
            .content-title,
            .hs-menu nav a .menu_name,
            .aside1 .aside-content .part1,
            #header .news-scroll span,
            .tabs-left > .nav-tabs > li > a ,
            .tab-pane h3,
            .resume > li > .timeline-item > .timeline-location,
            .resume > li > .timeline-item > .timeline-header,
            .card-drop a,
            .card-drop > a.toggle,
            .sorting-button span,
            .media h3,
            .publication-detail .publication_title,
            .slide-header h3,
            .teaching-section .teaching > li > .timeline-item > .timeline-header,
            .pricing-table-wrapper .pricing-table-header h1,
            .pricing-table-wrapper .pricing-table-header h3,
            .pricing-table-wrapper .signup,
            .proceess_wrap #ourprocess .action-button,
            .proceess_wrap #progressbar li,
            .portfol-filter .card-drop-portfolio a,
            .portfol-filter .card-drop-portfolio > a.toggle,
            .portfolio-wrapper figure h3,
            .portfolio-wrapper figure .label,
            .work_desc .project_content .project_title,
            .post-container .title-wrap h2 ,
            .post-container .mypost-meta,
            .post-container .mypost-meta .read-more,
            .mypost_pagination_loop li,
            .post-container .sharebuttons .sharebuttons_title,
            .post-container .author_box-info h3,
            .post-container .author_box-info p,
            .post-container .comment-navigation,
            .comments-title,
            .comment-author .fn,
            .reply,
            .comment-reply-title,
            .comment-notes,
            .comment-form input,
            .comment-form textarea,
            .comment-form label,
            .comment-awaiting-moderation,
            .hs-sidebar .widget-title,
            .nav-links,
            .service-section .serv-wrap .servicelistt ul li
            .portfocount_container,
            .portfocount_container span,
            .skilltitle,
            .verticaltab .mytabtitle,
            .service-section .serv-wrap h3,
            .service-section .serv-wrap .servicelistt ul li,
            .proceess_wrap #ourprocess .proceess h3,
            .page-title,
            .no-results .page-content .search-field,
            .no-results .page-content .search-submit,
            .wpcf7 input[type='submit'] ,
            .post-container .btags a
            
            {
             font-family: $heading_p_font;
            }
            .wpcf7 input[type='text'],
            .wpcf7 input[type='email'],
            .wpcf7 textarea,
            .comment-form input ,
            .hs-sidebar .widget input[type='search']
             {
             font-family: $heading_p_font !important;
            }
            </style>";
        }
    }

    add_action('wp_head', 'pulse_custom_css2');
}
/**
 * Remove page builder widgets from widgets admin area
 */
add_action('admin_print_styles-widgets.php', 'pulse_widgets_style');

function pulse_widgets_style() {
    echo <<<EOF
<style type="text/css">
div.widget[id*=_pulse_]{
    display:none;
}
</style>
EOF;
}

/**
 * Add favicon.
 */
function pulse_favicon() {
    if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
    if (function_exists('ot_get_option')) {
        $favicon = '<link rel="icon" type="image/png" href="' . esc_url(ot_get_option('pulse_favicon')) . '" />';
        echo wp_kses($favicon,array("link"=>array("rel"=>array(),"type"=>array(),"href"=>array())));
    }
}
}

add_action('wp_head', 'pulse_favicon');

/**
 * Add demoimporter_settings
 */

function pulse_demoimporter_settings() {
    $pagefront = get_page_by_title( 'HOME');
    $pagepost = get_page_by_title( 'BLOG');
    if( function_exists('update_option') ) {
       update_option( 'show_on_front', 'page' );
       update_option( 'page_on_front', $pagefront->ID );
       update_option( 'page_for_posts', $pagepost->ID );
       update_option( 'posts_per_page', 4 );
    }  
}
add_action('radium_import_end', 'pulse_demoimporter_settings');