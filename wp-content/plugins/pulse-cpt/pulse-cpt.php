<?php

/**
 * Plugin Name: PULSE CPT
 * Description: PULSE CUSTOM POST TYPE
 * Version: 1.0.0
 * Author: CODIUX
 * Author URI: http://themeforest.net/user/codiux
 */


/* 
 * Custom post types
 */

function publications_posttype() {
    $labels = array(
		'name'               => 'Publications',
		'singular_name'      => 'Publication',
		'menu_name'          => 'Publications',
		'name_admin_bar'     => 'Publication',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Publication',
		'new_item'           => 'New Publication',
		'edit_item'          => 'Edit Publication',
		'view_item'          => 'View Publication',
		'all_items'          => 'All Publications',
		'search_items'       => 'Search Publications',
		'parent_item_colon'  => 'Parent Publications:',
		'not_found'          => 'No Publications found.',
		'not_found_in_trash' => 'No Publications found in Trash.',
	);
    $args = array (
        	'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
                'menu_icon'          => 'dashicons-welcome-write-blog',
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type('publications', $args);
}
add_action('init', 'publications_posttype');

add_action( 'init', 'publications_taxonomies' );

function publications_taxonomies() {
	$labels = array(
		'name'              => 'Publication types',
		'singular_name'     => 'Publication type',
		'search_items'      => 'Search Publication types',
		'all_items'         => 'All Publication types',
		'parent_item'       => 'Parent Publication type',
		'parent_item_colon' => 'Parent Publication type:',
		'edit_item'         => 'Edit Publication type',
		'update_item'       => 'Update Publication type',
		'add_new_item'      => 'Add New Publication type',
		'new_item_name'     => 'New Publication type Name',
		'menu_name'         => 'Publication types',
	);

	$args = array(
                'public' => true,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => false,
	);

	register_taxonomy( 'publi-types', 'publications', $args );
}

/*
 * Metaboxes
 */


// Add the Meta Box
function add_publication_meta_box() {
    add_meta_box(
            'publication_meta_box', // $id
            'Publications Metabox', // $title 
            'show_publication_meta_box', // $callback
            'publications', // $page
            'normal', // $context
            'high'); // $priority
}

add_action('add_meta_boxes', 'add_publication_meta_box');

// Field Array
$prefix = 'pubmet_';
$publication_meta_fields = array(

    array(
        'label' => 'Publication location',
        'desc' => 'Location of the publication.',
        'id' => $prefix . 'publocation',
        'type' => 'text'
    ),
    array(
        'label'=> 'Publication description',
        'desc'  => 'Description of the publication.',
        'id'    => $prefix . 'pubdescription',
        'type'  => 'textarea'
    ),
    array(
        'label' => 'Publication date',
        'desc' => 'Date of the publication. format : aaaa-mm-dd',
        'id' => $prefix . 'pubdate',
        'type' => 'date'
    ),
    array(
        'label' => 'Publication authors',
        'desc' => 'Authors of the publication.',
        'id' => $prefix . 'pubauthor',
        'type' => 'text'
    ),
    array(
        'label' => 'Selected',
        'desc' => 'selected publication',
        'id' => $prefix . 'pubselected',
        'type' => 'checkbox'
    ),
    array(
        'label' => 'Publication external Link',
        'desc' => 'External link of the publication.',
        'id' => $prefix . 'pubextlink',
        'type' => 'text'
    )
);

// The Callback
function show_publication_meta_box() {
    global $publication_meta_fields, $post;
// Use nonce for verification
    wp_nonce_field( basename( __FILE__ ), 'publication_meta_box_nonce' );

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($publication_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
                <td>';
        switch ($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" />
                <br /><span class="description">' . $field['desc'] . '</span>';
                break;
            // Date
            case 'date':
                echo '<input type="text" class="datepicker" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" />
		<br /><span class="description">' . $field['desc'] . '</span>';
                break;
            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                <label for="'.$field['id'].'">'.$field['desc'].'</label>';
            break;
            // textarea
            case 'textarea':
                echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
                    <br /><span class="description">'.$field['desc'].'</span>';
            break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_custom_meta($post_id) {
    global $publication_meta_fields;
     
    // verify nonce
    if (!isset($_POST['publication_meta_box_nonce']) || !wp_verify_nonce($_POST['publication_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($publication_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_custom_meta');

// Add All pages font awesome Meta Box

function custom_metabox_fontawesome ($post) {
    wp_nonce_field(basename(__FILE__), "custom_metabox_fontawesome-nonce");
    $fonticon_stored_meta = get_post_meta( $post->ID, 'iconfont-select', true );
    $icons = smk_font_awesome(); //The array
    ?>
    <p>
            <select name="iconfont-select" id="iconfont-select" class="widefat" style="font-family: 'FontAwesome', 'Open Sans';">
        <?php foreach ($icons as $icon => $iconcode) { ?>
                <option value="<?php echo $icon; ?>" <?php if(isset ( $fonticon_stored_meta) && $fonticon_stored_meta == $icon){echo 'selected="selected"';} ?>><?php echo str_replace("\\", "&#x", $iconcode) . '; ' . $icon; ?></option>
        <?php } ?>
            </select>
        </p>
<?php
}
function add_custom_meta_box()
{
    add_meta_box('pageicon-meta-box', 'PAGE / MENU ICON', 'custom_metabox_fontawesome', 'page', 'normal', 'high');
}
add_action("add_meta_boxes", "add_custom_meta_box");

function custom_metabox_fontawesome_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'custom_metabox_fontawesome-nonce' ] ) && wp_verify_nonce( $_POST[ 'custom_metabox_fontawesome-nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'iconfont-select' ] ) ) {
        update_post_meta( $post_id, 'iconfont-select', $_POST[ 'iconfont-select' ] );
    }
 
}
add_action( 'save_post', 'custom_metabox_fontawesome_save' );

//  Portfolio Postypes

function portfolio_posttype() {
    $labels = array(
		'name'               => 'Portfolios',
		'singular_name'      => 'Portfolio',
		'menu_name'          => 'Portfolios',
		'name_admin_bar'     => 'Portfolio',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Portfolio',
		'new_item'           => 'New Portfolio',
		'edit_item'          => 'Edit Portfolio',
		'view_item'          => 'View Portfolio',
		'all_items'          => 'All Portfolios',
		'search_items'       => 'Search Portfolios',
		'parent_item_colon'  => 'Parent Portfolios:',
		'not_found'          => 'No Portfolios found.',
		'not_found_in_trash' => 'No Portfolios found in Trash.',
	);
    $args = array (
        	'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
                'menu_icon'          => 'dashicons-clipboard',
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type('portfolio', $args);
}
add_action('init', 'portfolio_posttype');

add_action( 'init', 'portfolios_taxonomies' );

function portfolios_taxonomies() {
	$labels = array(
		'name'              => 'Portfolio types',
		'singular_name'     => 'Portfolio type',
		'search_items'      => 'Search Portfolio types',
		'all_items'         => 'All Portfolio types',
		'parent_item'       => 'Parent Portfolio type',
		'parent_item_colon' => 'Parent Portfolio type:',
		'edit_item'         => 'Edit Portfolio type',
		'update_item'       => 'Update Portfolio type',
		'add_new_item'      => 'Add New Portfolio type',
		'new_item_name'     => 'New Portfolio type Name',
		'menu_name'         => 'Portfolio types',
	);

	$args = array(
                'public' => true,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => false,
	);

	register_taxonomy( 'portf-types', 'portfolio', $args );
}

// Add the Meta Box
function add_portfolio_meta_box() {
    add_meta_box(
            'portfolio_meta_box', // $id
            'portfolio Metabox', // $title 
            'show_portfolio_meta_box', // $callback
            'portfolio', // $page
            'normal', // $context
            'high'); // $priority
}

add_action('add_meta_boxes', 'add_portfolio_meta_box');

// Field Array
$prefixx = 'portmet_';
$portfolio_meta_fields = array(
    array(
        'label' => 'Portfolio external Link',
        'desc' => 'The work url.',
        'id' => $prefixx . 'portfurl',
        'type' => 'text'
    )
);
// The Callback
function show_portfolio_meta_box() {
    global $portfolio_meta_fields, $post;
// Use nonce for verification
    wp_nonce_field( basename( __FILE__ ), 'portfolio_meta_box_nonce' );

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($portfolio_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
                <td>';
        switch ($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" />
                <br /><span class="description">' . $field['desc'] . '</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_custom_meta_portfolio($post_id) {
    global $portfolio_meta_fields;
     
    // verify nonce
    if (!isset($_POST['portfolio_meta_box_nonce']) || !wp_verify_nonce($_POST['portfolio_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($portfolio_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_custom_meta_portfolio');

/*
 * Metaboxes for post formats
 */

// Add the Meta Box
function add_postformat_meta_box() {
    add_meta_box(
            'postformats_meta_box', // $id
            'Pulse post format options', // $title 
            'show_postformats_meta_box', // $callback
            'post', // $page
            'normal', // $context
            'high'); // $priority
}

add_action('add_meta_boxes', 'add_postformat_meta_box');
// Field Array
$prefixxx = 'postformats_';
$postformats_meta_fields = array(
    array(
        'label' => 'Video Embed',
        'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at http://codex.wordpress.org/Embeds..',
        'id' => $prefixxx . 'postvideo_embed',
        'type' => 'text'
    ),
    array(
        'label' => 'Audio Embed',
        'desc' => 'Enter a soundcloud URL.',
        'id' => $prefixxx . 'postaudio_embed',
        'type' => 'text'
    )
);

// The Callback
function show_postformats_meta_box() {
    global $postformats_meta_fields, $post;
// Use nonce for verification
    wp_nonce_field( basename( __FILE__ ), 'postformats_meta_box_nonce' );

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($postformats_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
                <td>';
        switch ($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" />
                <br /><span class="description">' . $field['desc'] . '</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_postformat_meta($post_id) {
    global $postformats_meta_fields;
     
    // verify nonce
    if (!isset($_POST['postformats_meta_box_nonce']) || !wp_verify_nonce($_POST['postformats_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($postformats_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_postformat_meta');