<?php
/*
  Template Name: Portfolio page
 */
if (is_page_template('page-portfolio.php')) {
    get_header();
    ?>
    <div class="pagecontainer">
        <header class="entry-header">
        <?php the_title('<h2 class="entry-title singlepage-title">', '</h2>'); ?>
        </header><!-- .entry-header -->
    <?php }
    ?>
<div class="row portfol-form">
    <div class="col-md-6 portfol-filter">
        <div class="card-drop-portfolio">
            <a class='toggle'>
                <i class='icon-suitcase'></i>
                <span class='label-active'>ALL</span>
            </a>
            <?php
            $terms = get_terms("portf-types");
            $count = count($terms);
            echo '<ul id="portfoliofilter">';
            wp_kses(_e('<li class="active"><a data-label="ALL" data-group="all">ALL</a></li>','pulse'),
                array('li'=>array('class'=>array()),
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
    <?php
$loop = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => -1));
?>
    <div class="col-md-6 portfocount">
            <div class="portfocount_container">
                <?php echo '<span>'.esc_html__('Projects number', 'pulse').'</span>' ?>
                <span class="pnumbercount"><?php echo esc_html($loop ->post_count); ?></span>
            </div>


        </div>
</div>


<div class="portfolio portfolio-wrapper" id="mygridportfolio">
    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
    <figure class="portfol_item effect-milo" data-groups='["all"<?php $terms = get_the_terms( $post->ID , "portf-types" ); $count = count($terms); if ( $count > 0 ){ foreach ( $terms as $term ) { echo ',"'.$term->name.'"'; } }?>]'>
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail( '', array( 'class' => 'img-responsive' ) ); ?> 
        <?php endif; ?>
        <figcaption>
            <div class="spa-wrap">
                <?php $terms2 = get_the_terms( $post->ID , "portf-types" ); $count2 = count($terms2); if ( $count2 > 0 ){ foreach ( $terms2 as $term ) { echo '<span class="label">'.$term->name.'</span>'; } }?>
            </div>
            
            <div class="portfolio_button">
                <h3><?php the_title(); ?></h3>
                <a href="<?php echo ".portfolio".$post->ID; ?>" class="open_popup" data-effect="mfp-zoom-out">
                    <i class="hovicon effect-9 sub-b"><i class="fa fa-plus"></i></i>
                </a>
            </div>
            <div class="mfp-hide mfp-with-anim work_desc <?php echo "portfolio".$post->ID; ?>">
                <div class="col-md-6">
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="image_work">
                        <?php the_post_thumbnail( '', array( 'class' => 'img-responsive' ) ); ?> 
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <div class="project_content">
                        <h2 class="project_title"><?php the_title(); ?></h2>
                        <div class="project_desc"><?php the_content(); ?></div>
                    </div>
                </div>
                <?php
                    if(!null == get_post_meta( $post->ID, 'portmet_portfurl', true )){ ?>
                <a class="ext_link" href="<?php echo get_post_meta( $post->ID, 'portmet_portfurl', true ); ?>" target="_blank"><i class="fa fa-external-link"></i></a>
                <?php }
                    ?>
                <div style="clear:both"></div>
            </div>
        </figcaption>
    </figure>
     <?php endwhile; ?>
</div>
<?php
if (is_page_template('page-portfolio.php')) {
    echo '</div>';
    get_footer();
}
?>
