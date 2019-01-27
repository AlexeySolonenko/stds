<?php


/**
 * Main Ajax Router
 */
class AjaxRouter {
    
    const POSTER_DIRECTIVES = [
        'update_post',
        'load_post'
    ];
    
    const BE_PAGES_DIRECTIVES = [
        'load_activate_hot_offers_form',
    ];
    
    
    const BE_PAGES_ROUTER = 300;
    
    
    /**
     * @param array $post
     * @return string
     */
    public function index($post) {
        //TODO to make a mandatory call for filter rules
        $req = \Stds\Types\AjaxRequestSingle::singleton();
        $res = \Stds\Types\AjaxResponseSingle::singleton();
        $directive = $post['directive'];
        error_log(print_r($req,true));
        $group = $post['group'];
        $_ = new \Stds\Types\AjaxDefs();
        if(in_array($req->getDirective(), $_::POSTER_DIRECTIVES)):
            require(get_stylesheet_directory().'/inc/poster/routes/poster_ajax_router.php');
            if(class_exists("PosterAjaxRouter", false)) $_pr = new PosterAjaxRouter();
            
            return $_pr->index($post);
        elseif($_::BE_PAGES_ROUTER == $req->getGroup()):
            (new \Stds\BeRoutes\BePagesAjaxRouter())->index($post);
        else:
            $res->addErrors('Group not found');
        endif;
        
        return $res->jsonSerialize();
        
    }
}
?>