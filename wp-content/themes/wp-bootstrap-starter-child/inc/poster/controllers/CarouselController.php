<?php
if(!class_exists('NewsCarousel')) require(get_stylesheet_directory().'/inc/poster/view_types/NewsCarousel.php');
if(!class_exists('NewsCarouselTemplate')) require(get_stylesheet_directory().'/inc/poster/view_templates/NewsCarouselTemplate.php');

class CarouselController {
    
    public function updatePost($post){ 
        $_c = new NewsCarousel();
        $_c->setContent($post['content']);
        $_c->setContentClass($post['content_class']);
       
        $config = json_encode($_c->toArray());
        $id = 91;
        $args = [
        'ID' => $id,
            'post_content' => $config,
            'post_title' => 'Carousel form',
            'post_slug' => 'poster-config-carousels-'.$id,
            'post_category' => [get_category_by_slug( 'poster-configs-carousels' )->term_id],
            'post_status'       =>  'publish'
        ];
        
        $ret = wp_insert_post($args);
        if($ret === false || (int)$ret === 0) $msg = 'Post update failed';
        if(is_numeric($ret)) $msg = "Post {$ret} updated successfully.";
        
        return json_encode(['msg' => $msg]);
        /*
	$whatever = 25;
	ob_clean();
        echo $whatever;
	
            return 'from carousel';*/

    }
    
    public function loadPost($post){
        $_t = new NewsCarouselTemplate();
        $post = get_post(91);
        $config = json_decode($post->post_content, true);
        $html = $_t->render($config);
        return json_encode(['html' => $html]);
    }
   
}