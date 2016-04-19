<?php
/**
 * @package pulse
 */
?>
<?php $audio_url = get_post_meta($post->ID, "postformats_postaudio_embed", true); ?>
<?php $video_url = get_post_meta($post->ID, "postformats_postvideo_embed", true); ?>

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
                            <?php the_title(sprintf('<h2 class="entry-title pulse-post-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
                            <span class="pulse-post-author"><?php esc_html_e('By', 'pulse'); ?> <span><?php the_author(); ?> </span></span>
                        </div>

                    </div>
                </header><!-- .entry-header -->
                <?php
                if (!has_post_format()) {
                    if (has_post_thumbnail()) {
                        echo '<div class="mypost-thumb">';
                        echo '<a  href="' . get_permalink() . '" title="' . 'Click to read' . get_the_title() . '" rel="bookmark">';
                        echo the_post_thumbnail('pulse_mypost_image');
                        echo '</a>';
                        echo '</div>';
                    }
                } elseif (has_post_format('audio')) {
                    ?>
                    <div class="videopost_format">
                        <?php echo apply_filters('the_content', $audio_url); ?> 
                    </div>
                <?php } elseif (has_post_format('video')) { ?>
                    <div class="videopost_format">
                        <?php echo apply_filters('the_content', $video_url); ?> 
                    </div>

                <?php } ?>
                <div class="entry-content">
                    <div class="post-inner">
                        <div class="post-content">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div><!-- .entry-content -->
                <div class="mypost-meta">
                    <?php if (!has_post_format()) { ?>
                        <div class="post-format-icon"><i class="fa fa-thumb-tack"></i></div>
                    <?php } elseif (has_post_format('video')) { ?>
                        <div class="post-format-icon"><i class="fa fa-film"></i></div>
                    <?php } elseif (has_post_format('audio')) { ?>
                        <div class="post-format-icon"><i class="fa fa-music"></i></div>
                    <?php } ?>
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
                        
                    </div>     
                    <?php wp_kses(printf(__('<div class="read-more"><a href="%s" title="Continue Reading %s" rel="bookmark">READ MORE</a></div>','pulse'),get_permalink() ,get_the_title()),array('div'=>array('class'=>array()),'a'=>array('href'=>array(),'title'=>array()))); ?>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post-## -->