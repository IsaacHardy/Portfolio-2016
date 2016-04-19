<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package pulse
 */

get_header(); ?>

	<div id="primary" class="content-area pagecontainer404">

			<section class="error-404 not-found">
                                 <div id="clouds">
            <div class="cloud x1"></div>
            <div class="cloud x1_5"></div>
            <div class="cloud x2"></div>
            <div class="cloud x3"></div>
            <div class="cloud x4"></div>
            <div class="cloud x5"></div>
        </div>
        <div class='c'>
            <div class='_404'>404</div>
            <?php echo '<div class="_1">'.esc_html__('Oops! That page can&rsquo;t be found.', 'pulse').'</div>' ?>
            <a class='btn' href='<?php echo esc_url( home_url( '/' ) ); ?>'><?php esc_html_e('BACK TO HOME', 'pulse'); ?></a>
        </div>
				

			
			</section><!-- .error-404 -->

	</div><!-- #primary -->

<?php get_footer(); ?>
