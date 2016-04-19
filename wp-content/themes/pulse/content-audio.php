<?php
/**
 * @package pulse
 */
?>
<?php $audio_url = get_post_meta( $post->ID, "postformats_postaudio_embed", true ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="content-wrapper">
        <div class="post-wrapper">
            <div class="post-box">
                <header class="entry-header">
                    <div class="mypost-title">
                        <div class="mypost-date">
                            <span class="mypost-day" ><?php echo get_the_time('d'); ?></span>
                            <span class="mypost-month" ><?php echo get_the_time('M'); ?></span>
                            <span class="mypost-year" ><?php echo get_the_time('Y'); ?></span>
                        </div>
                        <div class="title-wrap">
                            <?php the_title('<h2 class="entry-title pulse-post-title">', '</h2>'); ?>
                            <span class="pulse-post-author">By <span><?php the_author(); ?> </span></span>
                        </div>

                    </div>
                </header><!-- .entry-header -->
                <div class="videopost_format">
                   <?php echo apply_filters('the_content', $audio_url); ?> 
                </div>
                <div class="entry-content">
                    <div class="post-inner">
                        <div class="post-content">
                            <?php the_content(); ?>
                            <p class="btags"><?php the_tags( '','' ); ?></p>
                        </div>
                    </div>
                </div><!-- .entry-content -->
                <div class="mypost-meta">
                    <div class="post-format-icon"><i class="fa fa-music"></i></div>
                    <div class="postmetwrap">
                    <span class="post-cat"><i class="fa fa-folder"></i>
                        <?php
                        $cats = '';
                        foreach ((get_the_category()) as $category) {
                            $cats = $cats . $category->cat_name . ' &bull; ';
                        }
                        $cats = substr($cats, 0, -8);
                        echo esc_html($cats);
                        ?>

                    </span>

                    <?php
                    echo '<span class="comments-link post-comment"><i class="fa fa-comments"></i>';
                    comments_popup_link(esc_html__('Leave a comment', 'pulse'), esc_html__('1 Comment', 'pulse'), esc_html__('% Comments', 'pulse'));
                    echo '</span>';
                    ?>

                    <?php edit_post_link(esc_html__('Edit', 'pulse'), '<span class="edit-link">', '</span>'); ?>
                        
                    </div>
                </div>
                <?php if (ot_get_option('blog_facebook') == 'on' or ot_get_option('blog_twitter') == 'on' or ot_get_option('blog_googleplus') == 'on' or ot_get_option('blog_pinterest') == 'on') { ?>
                    <div class="pulseshareon">
                        <?php if (ot_get_option('blog_facebook') == 'on') { ?>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" ><i class="fa fa-facebook"></i></a>
                        <?php } ?>
                        <?php if (ot_get_option('blog_twitter') == 'on') { ?>
                            <a href="https://twitter.com/home?status=<?php the_permalink(); ?>" target="_blank" ><i class="fa fa-twitter"></i></a>
                        <?php } ?>
                        <?php if (ot_get_option('blog_googleplus') == 'on') { ?>
                            <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" ><i class="fa fa-google-plus"></i></a>
                        <?php } ?>
                        <?php if (ot_get_option('blog_pinterest') == 'on') { ?>
                            <a href="https://pinterest.com/pin/create/button/?url=&media=&description=<?php the_permalink(); ?>" target="_blank" ><i class="fa fa-pinterest"></i></a>
                        <?php } ?>
                    </div>           
                <?php } ?>
                <div class="entry-content">
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'pulse'),
                        'after' => '</div>',
                    ));
                    ?>
                </div><!-- .entry-content -->


            </div>
        </div>
    </div>


</article><!-- #post-## -->
