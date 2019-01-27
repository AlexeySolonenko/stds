<?php
// FRONT PAGE MAIN SCRIPT

$ret = wp_register_script('ajax_common_js',get_stylesheet_directory_uri()."/inc/assets/js/ajax_common.js",[],false,true);
$ret = wp_register_script('lodash',"https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js",[],false,true);
$ret = wp_register_script('toastr',"//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js",[],false,true);
$r = new \ReflectionClass((new \Stds\Types\AjaxDefs()));
$ajaxConsts = $r->getConstants();
$r = new \ReflectionClass((new \Stds\BeRoutes\BePagesAjaxRouter()));
$ajaxConsts = array_merge($ajaxConsts,$r->getConstants());
$r = new \ReflectionClass((new \Stds\Types\MediaHandlerSettings()));
$ajaxConsts = array_merge($ajaxConsts,$r->getConstants());

function front_page_js_script(){
    if(is_front_page()){
        wp_register_script('front_page_js',get_stylesheet_directory_uri()."/inc/assets/js/pages/front_page.js",['jquery','wp-bootstrap-starter-bootstrapjs'],'',true);
        wp_enqueue_script('front_page_js');
        //wp_enqueue_script('ajax_common_js');
        wp_localize_script( 'front_page_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
        //wp_localize_script( 'ajax_common_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
    }
}
add_action('wp_enqueue_scripts','front_page_js_script',20,1);

function manage_front_page_script(){
    global $ajaxConsts;
    $fp = new \Stds\Types\FrontPage();
    $r = new \ReflectionClass($fp);
    $ajaxConsts = array_merge($ajaxConsts,[$fp::FRONT_PAGE => $r->getConstants()]);
      if(is_page_template('template-manage_front_page.php')){
        wp_register_script('manage_front_page_js',get_stylesheet_directory_uri()."/inc/assets/js/pages/manage_front_page.js",['jquery','wp-bootstrap-starter-bootstrapjs','ajax_common_js','lodash','toastr'],'',true);
        wp_enqueue_script('manage_front_page_js');
        $ajax_object = ["ajax_url" => admin_url( 'admin-ajax.php') ];
        $ajax_object = array_merge($ajax_object,$ajaxConsts);
        wp_localize_script( 'manage_front_page_js', 'ajax_object',$ajax_object);
     }
}
add_action('wp_enqueue_scripts','manage_front_page_script',22,1);

function create_news_post_js_script(){
      if(is_page_template('template-create_news_post.php')){
        wp_register_script('news_posts_js',get_stylesheet_directory_uri()."/inc/assets/js/posts/news_posts.js",['jquery','wp-bootstrap-starter-bootstrapjs'],'',true);
        wp_enqueue_script('news_posts_js');
        wp_localize_script( 'news_posts_js', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
     }
}
add_action('wp_enqueue_scripts','create_news_post_js_script',23,1);