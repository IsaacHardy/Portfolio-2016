<?php
/**
 * The template for displaying search results pages.
 *
 * @package pulse
 */

get_header(); ?>

        	<div id="blog" class="blog-body col-md-9 col-sm-8">
            <div class="post-container row">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
                        
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'pulse' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>

			<?php the_pulse_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
            </div>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
