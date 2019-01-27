<?php

/**
 * 
 * 
 */

class PosterAjaxRouter {

    public function index($post){
         $directive = $post['directive'];
        if('update_post' === $directive):

            require(get_stylesheet_directory().'/inc/poster/controllers/CarouselController.php');
            if(class_exists("CarouselController", false)) $_c = new CarouselController();

            return $_c->updatePost($post);
        elseif('load_post' === $directive):
            if(!class_exists("CarouselController", false)) {
                require(get_stylesheet_directory().'/inc/poster/controllers/CarouselController.php');
            }
            if(class_exists("CarouselController", false)) $_c = new CarouselController();
            return $_c->loadPost($post);
        endif;
    }
}

?>