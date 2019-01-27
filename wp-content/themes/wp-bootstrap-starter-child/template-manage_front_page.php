<?php
/**
 * Template name: Manage Front Page
 */

get_header(); 
$v = new \Stds\BeViews\ManageFrontPageView();?>
	<section id="primary" class="content-area col-sm-12 col-lg-8">
		<main id="main" class="site-main" role="main">
		    <div class="container">
		        <div class="row <?php echo $v::SELECT_FORM; ?>">
		            <div class="col-12">
		                <?php  echo $v->buildFormSelector(); ?>
    		        </div>
		        </div>
		        <div class="row <?php echo $v::CURRENT_FORM; ?> d-none">
		            <div class="col-12">
		                <div class="card">
		                    <div class="card-header"></div>
		                    <div class="card-body manage_front_page_body "></div>
		                </div>
		            </div>
		        </div>
	        </div>
	        <?php
	        
		?>
		</main><!-- #main -->
	</section><!-- #primary -->
<?php
//get_sidebar();
get_footer();
?>