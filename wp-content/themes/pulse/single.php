<?php
/**
 * The template for displaying all single posts.
 *
 * @package pulse
 */
get_header();
?>
<div class=" blog-body col-md-9 col-sm-8">

<div class="post-container row">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php while (have_posts()) : the_post(); ?>
                <?php
                if (!get_post_format()) {
                    get_template_part('content', 'single');
                } else {
                    get_template_part('content', get_post_format());
                }
                ?>

                <?php 
                if (ot_get_option('blog_postnav') == 'on') { 
                    the_post_navigation(); 
                }
                
                ?>
                <?php
                $author = get_the_author();
                $author_description = get_the_author_meta('description');
                $author_url = esc_url(get_author_posts_url(get_the_author_meta('ID')));
                $author_avatar = get_avatar(get_the_author_meta('user_email'), apply_filters('wpex_author_bio_avatar_size', 170));
                if (ot_get_option('blog_authorbox') == 'on') {    
                if ($author_description) :
                    ?>

                    <div class="author_box">
                        <?php if ($author_avatar) { ?>
                            <div class="author_box_avatar">
                                <a href="<?php echo esc_url($author_url); ?>" rel="author">
                                    <?php echo balanceTags($author_avatar,true); ?>
                                </a>
                            </div><!-- .author-avatar -->
                        <?php } ?>
                        <div class="author_box-info">

                            <h3><?php echo esc_html($author); ?></h3>
                            <p><?php echo balanceTags($author_description,true); ?></p>
                            <p><a href="<?php echo esc_url($author_url); ?>" title="<?php esc_html_e('View all author posts', 'pulse'); ?>"><?php esc_html_e('View all author posts', 'pulse'); ?> &rarr;</a></p>

                        </div>
                    </div>
                <?php endif; 
                }
                ?>
                <?php
                // If comments are open or we have at least one comment, load up the comment template
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; // end of the loop. ?>

        </main><!-- #main -->
    </div><!-- #primary -->
</div>  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
