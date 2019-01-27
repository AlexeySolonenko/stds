<?php
/**
 * Template name: Create News Post 
 */
 
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */


get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-lg-8">
		<main id="main" class="site-main" role="main">

			<?php


function createTestNewPostsPost(){
    $html = "";
    //ob_clean();
    ob_start();
    ?>
        <form id="test_new_post" name="test_new_post" method="POST">
            <div>Post name</div><input name="new_test_post_name" type="text" value="">
            <div>Post category</div><input name="new_test_post_category" type="text" value="">
            <div>Post content</div><input name="content" type="text" value="">
            <div>Post content class</div><input name="content_class" type="text" value="">
            <div>Update</div><button type="button" class=" update_post btn btn_update">Update</button>
            <div>Load</div><button type="button" class = "load_post btn btn-primary">Load</button>
        </form>
    <?php
    $html = ob_get_contents();
    ob_end_clean();
    $post = [
        'ID' => '76',
            'post_content' => $html,
            'post_title' => 'Carousel form',
            'post_slug' => 'crousel-form',
            'post_category' => [get_category_by_slug( 'tools' )->term_id],
            'post_status'       =>  'publish'
        ];
    return $post;
}
wp_delete_post(74);
wp_delete_post(75);
$post = createTestNewPostsPost();
$postId = wp_insert_post($post);

if(is_page_template('template-create_news_post.php')){
    echo "Post IDd {$postId}";
    
}


			echo 'create new posts page';
			nl(2);
			?>
			
			<div class="container">
			    <div class="row">
			        <div class="col " >
			            <div class="card bg-warning">
			                <div class="card-body" >
			                    <div class="row">
			                        <div class="col-4">
        			                    <picture>
        			                        <source>
        			                        <img class="img-fluid" src="http://transfer.tab4lioz.beget.tech/wp-content/uploads/2018/02/inst_icon_temporary.png" class="rounded float-left" alt="test image. Instagram icon">
        			                    </picture>
    			                    </div>
    			                    
        			                    <p class="col-8">Sample promotion text</p>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		
			<?php
			nl(2);
			$b = new \Stds\View\BlockBuilder();
			$_ = new \Stds\ViewTypes\BlockProps();
		
		    $objChild = new \stdClass();
		    $objChild->{$_::VIEW_CLASS} = \Stds\ViewBlocks\ColRowBlock::class;
		    $objConf = new \stdClass();
		    $objConf->{$_::PRE_CONTENT} = '<div class="col-6"> <br /> El 3.1.4 OBJECT Child  3 level 3 in array <br /></div>';
            $objConf->{$_::ROW_CLASS} = 'row bg-danger';
            $objConf->{$_::COL_CLASS} = 'col-10 border border-dark';
            $objChild->{$_::CONF} = $objConf;
            
		    
			$conf = [
			    [
			        $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
			        $_::CONF => [
			            $_::PRE_CONTENT => '<div class="col-6"> <br/> El 1 Level 0 without children <br /></div>',
			            $_::ROW_CLASS => 'row bg-secondary',
			            $_::COL_CLASS => 'col-10 border border-dark'
			        ],
	            ],

			    [    
			        $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
			        $_::CONF => [
			            $_::PRE_CONTENT => '<div class="col-6"> <br /> El 2 Level 0 with children <br /></div>',
			            $_::ROW_CLASS => 'row bg-primary',
			            $_::COL_CLASS => 'col-10 border border-dark'
			        ],
			        $_::CHILDREN => [
			            [ 
			                $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
    			            $_::CONF => [
			                    $_::PRE_CONTENT => ' <div class="col-6"> <br /> El 2.1 Level 1 arraiefied child 1 <br /></div>',
			                    $_::ROW_CLASS => 'row bg-warning'
			                ],
			                $_::CHILDREN => [
			                  $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
    			                $_::CONF => [
			                        $_::PRE_CONTENT => ' <div class="col-6"> <br /> E2.1.2  Child level 3 not enclosed array <br /></div>',
			                        $_::ROW_CLASS => 'row bg-info'
			                    ],  
			                ]
			            ]
		            ]
		        ],
		         [    
			        $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
			        $_::CONF => [
			            $_::PRE_CONTENT => ' <div class="col-6"> <br /> El 3. Level 0 with a single child not enclosed in an array <br /></div>',
			            $_::ROW_CLASS => 'row bg-danger',
			            $_::COL_CLASS => 'col-10 border border-dark'
			        ],
			        $_::CHILDREN => [
			            
			                $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
    			            $_::CONF => [
			                    $_::PRE_CONTENT => ' <div class="col-6"> <br /> El 3.1 Level 1 not enclosed in an array but with multiple children in an array <br /></div>',
			                    $_::ROW_CLASS => 'row bg-secondary',
			                    $_::COL_CLASS => 'col-10 border border-dark',
			                ],
			                $_::CHILDREN => [
			                    [
			                      $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
    			                    $_::CONF => [
			                            $_::PRE_CONTENT => '<div class="col-6"> <br /> El 3.1.1 Child 1 level 3 in array <br /></div>',
			                            $_::ROW_CLASS => 'row bg-success'
			                        ],
		                        ],
		                        [
			                      $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
    			                    $_::CONF => [
			                            $_::PRE_CONTENT => ' <div class="col-6"><br /> El 3.1.2 Child  2 level 3 in array <br /></div>',
			                            $_::ROW_CLASS => 'row bg-white'
			                        ],
		                        ],
		                        [
			                      $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
    			                    $_::CONF => [
			                            $_::PRE_CONTENT => '<div class="col-6"> <br /> El 3.1.3 Child  3 level 3 in array <br /></div>',
			                            $_::ROW_CLASS => 'row bg-primary'
			                        ],
		                        ],
		                         [
			                      $_::VIEW_CLASS=> \Stds\ViewBlocks\ColRowBlock::class,
    			                    $_::CONF => $objConf
		                        ],
			                ]
			            
		            ]
		        ],
		        
		    ];
		    		    echo "<div class=\"container\">";
		    echo "<div class=\"row\">";
		    echo $b->render("", $conf);
		    echo "</div>";
		    echo "</div>";
			echo '<br />';
			echo '<br />';
			
			//$d = new \Stds\ViewTemplates\ColRowTemplate();
			//$d->render();
			
			echo "<a href=\"http://transfer.tab4lioz.beget.tech/service-area/\" >link to a private page</a>";
			rewind_posts();
			echo "<div class=\"cntnr   \"></div>";
			
			echo "<div class=\"msg_cntr   \"></div>";
			echo "<br />";
			$args = [
			    "category" => get_category_by_slug( 'tools' )->term_id
			    ];
			$posts = get_posts($args);
			foreach($posts as $post){
			    setup_postdata($post);
			    ?>
			    <br />
			    <?php echo the_content(); ?>
			    <br />
			    <?php
			}
		
		$posterId = get_category_by_slug('news')->term_id;
		get_term_children($posterId, 'category');
		$args = [
          'post_type' => 'post',
          'posts_per_page' => 100,
         
          'tax_query' => [
              'relation' => 'AND',
                [
                    'taxonomy' => 'category',
                    'field'    => 'name',
                    'terms'    => ['poster'],
                ],
                 [
                    'taxonomy' => 'category',
                    'field'    => 'name',
                    'terms'    => ['tools'],
                ],
            ],
        ];
        $q = new WP_Query( $args );
        $posts = $q->posts;
        $ret = false;
        foreach($posts as $post){
            if($post->post_name == 'tool-test-in-tools-2'){
                $ret = $post;
            }
        }
        echo "<pre>".$ret->post_content."</pre>";

			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
