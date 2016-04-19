<?php
/*
  Template Name: Publications page
 */
if (is_page_template('page-publications.php')) {
    get_header();
    ?>
    <div class="pagecontainer">
        <header class="entry-header">
            <?php the_title('<h2 class="entry-title singlepage-title">', '</h2>'); ?>
        </header><!-- .entry-header -->
    <?php }
    ?>
    <div class="row publication-form">
        <div class="col-md-6 publication-filter">
            <div class="card-drop">
                <a class='toggle'>
                    <i class='icon-suitcase'></i>
                    <span class='label-active'>ALL</span>
                </a>
                <?php
                $terms = get_terms("publi-types");
                $count = count($terms);
                echo '<ul id="filter">';
                wp_kses(_e('<li class="active"><a data-label="ALL" data-group="all">ALL</a></li>','pulse'),array('li'=>array('class'=>array()),
                      'a'=>array(
                           'data-label'=>array(),
                           'data-group'=>array()
                           )));
                if ($count > 0) {
                    foreach ($terms as $term) {
                        echo '<li><a data-label="' . esc_attr($term->name) . '" data-group="' . esc_attr($term->name) . '">' . esc_attr($term->name) . '</a></li> ';
                    }
                }
                echo "</ul>";
                ?>
            </div>
        </div>
        <div class="col-md-6 publication-sort">
            <div class="sorting-button">
                <?php echo '<span>'.esc_html__('SORTING BY DATE', 'pulse').'</span>' ;?>
                <button class="desc"><i class="fa fa-sort-numeric-desc"></i>
                </button>
                <button class="asc"><i class="fa fa-sort-numeric-asc"></i>
                </button>
            </div>


        </div>
    </div>
    <?php
    $loop = new WP_Query(array('post_type' => 'publications', 'posts_per_page' => -1));
    ?>
    <div id="mygrid">
        <?php while ($loop->have_posts()) : $loop->the_post(); ?>


            <div class="publication_item" data-groups='["all"<?php
            $terms = get_the_terms($post->ID, "publi-types");
            $count = count($terms);
            if ($count > 0) {
                foreach ($terms as $term) {
                    echo ',"' . $term->name . '"';
                }
            }
            ?>]' data-date-publication="<?php echo get_post_meta($post->ID, 'pubmet_pubdate', true); ?>">
                <div class="media">
                    <a href="<?php echo ".publication" . $post->ID; ?>" class="ex-link open_popup" data-effect="mfp-zoom-out"><i class="fa fa-plus-square-o"></i></a>
                    <div class="date pull-left">
                        <span class="day"><?php echo date('d', strtotime(get_post_meta($post->ID, 'pubmet_pubdate', true))); ?></span>
                        <span class="month"><?php echo date('M', strtotime(get_post_meta($post->ID, 'pubmet_pubdate', true))); ?></span>
                        <span class="year"><?php echo date('Y', strtotime(get_post_meta($post->ID, 'pubmet_pubdate', true))); ?></span>
                    </div>
                    <div class="media-body">
                        <h3><?php the_title(); ?></h3>
                        <h4><?php echo get_post_meta($post->ID, 'pubmet_publocation', true); ?></h4>
                        <span class="publication_description"><?php echo get_post_meta($post->ID, 'pubmet_pubdescription', true); ?></span> </div>
                    <hr style="margin:8px auto">
                    <?php
                    $terms2 = get_the_terms($post->ID, "publi-types");
                    $count2 = count($terms2);
                    if ($count2 > 0) {
                        foreach ($terms2 as $term) {
                            echo '<span class="label label-pub">' . $term->name . '</span>';
                        }
                    }
                    ?>
    <?php
    if (get_post_meta(get_the_ID(), 'pubmet_pubselected', true) == 'on') {
        echo '<span class="label selected">' . esc_html__('Selected', 'pulse') . '</span>';
    }
    ?>

                    <span class="publication_authors"><?php echo get_post_meta($post->ID, 'pubmet_pubauthor', true); ?></span>
                </div>
                <div class="mfp-hide mfp-with-anim <?php echo "publication" . $post->ID; ?> publication-detail">
    <?php if (has_post_thumbnail()) : ?>
                        <div class="image_work">
                            <?php the_post_thumbnail('', array('class' => 'img-responsive')); ?> 
                        </div>
                        <?php endif; ?>
                    <div class="project_content">
                        <h3 class="publication_title"><?php the_title(); ?></h3>
                        <span class="publication_authors"><?php echo get_post_meta($post->ID, 'pubmet_pubauthor', true); ?></span>
                        <?php
                        $terms2 = get_the_terms($post->ID, "publi-types");
                        $count2 = count($terms2);
                        if ($count2 > 0) {
                            foreach ($terms2 as $term) {
                                echo '<span class="label label-pub">' . $term->name . '</span>';
                            }
                        }
                        ?>
            <?php
            if (get_post_meta(get_the_ID(), 'pubmet_pubselected', true) == 'on') {
                echo '<span class="label selected">' . esc_html__('Selected', 'pulse') . '</span>';
            }
            ?>
                        <div class="project_desc"><?php the_content(); ?></div>
                    </div>
                    <?php
                    if(!null == get_post_meta($post->ID, 'pubmet_pubextlink', true)){ ?>
                        <a class="ext_link" target="_blank" href="<?php echo get_post_meta($post->ID, 'pubmet_pubextlink', true); ?>"><i class="fa fa-external-link"></i></a>
                   <?php }
                    ?>
                    
                    <div style="clear:both"></div>
                </div>
            </div>
    <?php endwhile;
    ?>
    </div>

<?php
if (is_page_template('page-publications.php')) {
    echo '</div>';
    get_footer();
}
?>

