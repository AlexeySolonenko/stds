<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-md-12 col-lg-8">
		<main id="main" class="site-main" role="main">
        
		<?php
		//<input type="text" name="post_title" value="1">
		// Create post object
$my_post = array(
  'post_title'    => "test post",
  'post_content'  => "<button class=\"btn btn-primary\" >button</button>",
  'post_status'   => 'publish',
  'post_author'   => 1,
  'post_category' => array( 8,39 )
);
wp_login_form();
 
// Insert the post into the database
//wp_insert_post( $my_post );
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; 
		//if (function_exists('usp_display_posts')) usp_display_posts();
		//if (function_exists('user_submitted_posts')) user_submitted_posts();
		
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
