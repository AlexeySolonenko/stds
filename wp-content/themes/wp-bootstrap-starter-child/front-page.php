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
$c = new \Stds\FeControllers\FrontPageController();

get_header(); ?>
<!-- <div id="content" class="site-content"> -->
       
    <div class="container-fluid">
            
    </div>
	<section id="primary" class="content-area col-sm-12 col-md-12 "> <!--col-lg-8"> -->
		<main id="main" class="site-main" role="main">
	       <div class="container">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <h1>Studysnammi to develop</h1>
                    </div>
                </div>
            </div><?php
            /*

                HOT OFERS 

            */
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div id="hot_offers" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner"><?php echo $c->getHotOffers(); ?> </div>
                          <a class="carousel-control-prev" href="#hot_offers" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#hot_offers" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div><?php

        
            ?><div class="container">
                <div class="row front_page_content_wrapper">
                    <div class="col-12 p-2 hero_image">
                        <div class="card">
                            <a href="http://debug.tab4lioz.beget.tech/" title=""><img class="card-img-top img-fluid" src="http://debug.tab4lioz.beget.tech/wp-content/uploads/2018/08/HEROIMG2.jpg" alt="Card image cap"></a>
                         
                        </div>
                    </div>
                    <div class="col-md-4 p-2 col-12">
                        <div class="card stds-texted-image">
                                <div class="position-absolute text-white  text-center stds-text-over-image-centered" >
                                    GALLERY
                                </div>
                             <a href="http://debug.tab4lioz.beget.tech/gallery" title=""><img class="card-img-top img-fluid" src="http://debug.tab4lioz.beget.tech/wp-content/uploads/2018/08/linkimg1_gallery2.jpg" alt="Card image cap"></a>
                       
                        </div>
                    </div> 
                                <div class="col-md-4  p-2 col-12">
                        <div class="card stds-texted-image">
                            <div class="position-absolute text-white  text-center stds-text-over-image-centered" >
                                    ORDERS
                                </div>
                            <a href="http://debug.tab4lioz.beget.tech/orders" title=""><img class="card-img-top img-fluid" src="http://debug.tab4lioz.beget.tech/wp-content/uploads/2018/08/linkimg2_orders2.jpg" alt="Card image cap"></a>
                       
                        </div>
                    </div> 
                                <div class="col-md-4 p-2 col-12">
                        <div class="card stds-texted-image">
                            <div class="position-absolute text-white  text-center stds-text-over-image-centered" >
                                    ABOUT ME
                                </div>
                            <a href="http://debug.tab4lioz.beget.tech/about-me" title=""><img class="card-img-top img-fluid" src="http://debug.tab4lioz.beget.tech/wp-content/uploads/2018/08/linkimg3_about_me2.jpg" alt="Card image cap"></a>
                        </div>
                    </div> 
                </div>
            </div>

        
            <h2>Language courses</h2>
            <div class="stds-color-secondary-text">
                <p>
text text
        </p>
        </div>

		<?php
		//if ( have_posts() ) :
            /*
			if ( is_home() && ! is_front_page() ) : error_log('page title');?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;
			*/

			/* Start the Loop */
			/*
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				//get_template_part( 'template-parts/content', get_post_format() );

			//endwhile;

			//the_posts_navigation();

		//else :

		//	get_template_part( 'template-parts/content', 'none' );

		//endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
