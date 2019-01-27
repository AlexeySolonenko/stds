<?php
function wp_bootstrap_starter_child_scripts(){
    $parent_style = [];

    
    
    // load bootstrap css
	wp_enqueue_style( 'wp-bootstrap-starter-bootstrap-css', get_template_directory_uri() . '/inc/assets/css/bootstrap.min.css' ,array(),null);
	$parent_style[] =      'wp-bootstrap-starter-bootstrap-css';
    
    // fontawesome cdn
    wp_enqueue_style( 'wp-bootstrap-pro-fontawesome-cdn', 'https://use.fontawesome.com/releases/v5.1.0/css/all.css' ,array(),null);
    $parent_style[] =  'wp-bootstrap-pro-fontawesome-cdn';
    wp_enqueue_style( 'toastr', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' ,array(),null);
    $parent_style[] = 'toastr';
	// load bootstrap css
	// load AItheme styles
	// load WP Bootstrap Starter styles
	wp_enqueue_style( 'wp-bootstrap-starter-style', get_template_directory_uri().'/style.css' );
	$parent_style[] = 'wp-bootstrap-starter-style';
    if(get_theme_mod( 'theme_option_setting' ) && get_theme_mod( 'theme_option_setting' ) !== 'default') {nl(30);
        wp_enqueue_style( 'wp-bootstrap-starter-'.get_theme_mod( 'theme_option_setting' ), get_template_directory_uri() . '/inc/assets/css/presets/theme-option/'.get_theme_mod( 'theme_option_setting' ).'.css', false, '' );
        $parent_style[] = 'wp-bootstrap-starter-'.get_theme_mod( 'theme_option_setting' );
    }
    if(get_theme_mod( 'preset_style_setting' ) === 'poppins-lora') {
        wp_enqueue_style( 'wp-bootstrap-starter-poppins-lora-font', 'https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i|Poppins:300,400,500,600,700' );
    }
    if(get_theme_mod( 'preset_style_setting' ) === 'montserrat-merriweather') {
        wp_enqueue_style( 'wp-bootstrap-starter-montserrat-merriweather-font', 'https://fonts.googleapis.com/css?family=Merriweather:300,400,400i,700,900|Montserrat:300,400,400i,500,700,800' );
        $parent_style[] ='wp-bootstrap-starter-montserrat-merriweather-font';
    }
    if(get_theme_mod( 'preset_style_setting' ) === 'poppins-poppins') {
        wp_enqueue_style( 'wp-bootstrap-starter-poppins-font', 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' );
         $parent_style[] ='wp-bootstrap-starter-poppins-font';
    }
    if(get_theme_mod( 'preset_style_setting' ) === 'roboto-roboto') {
        wp_enqueue_style( 'wp-bootstrap-starter-roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i' );
         $parent_style[] ='wp-bootstrap-starter-roboto-font';
    }
    if(get_theme_mod( 'preset_style_setting' ) === 'arbutusslab-opensans') {
        wp_enqueue_style( 'wp-bootstrap-starter-arbutusslab-opensans-font', 'https://fonts.googleapis.com/css?family=Arbutus+Slab|Open+Sans:300,300i,400,400i,600,600i,700,800' );
         $parent_style[] ='wp-bootstrap-starter-arbutusslab-opensans-font';
    }
    if(get_theme_mod( 'preset_style_setting' ) === 'oswald-muli') {
        wp_enqueue_style( 'wp-bootstrap-starter-oswald-muli-font', 'https://fonts.googleapis.com/css?family=Muli:300,400,600,700,800|Oswald:300,400,500,600,700' );
         $parent_style[] ='wp-bootstrap-starter-oswald-muli-font';
    }
    if(get_theme_mod( 'preset_style_setting' ) === 'montserrat-opensans') {
        wp_enqueue_style( 'wp-bootstrap-starter-montserrat-opensans-font', 'https://fonts.googleapis.com/css?family=Montserrat|Open+Sans:300,300i,400,400i,600,600i,700,800' );
         $parent_style[] ='wp-bootstrap-starter-montserrat-opensans-font';
    }
    if(get_theme_mod( 'preset_style_setting' ) === 'robotoslab-roboto') {
        wp_enqueue_style( 'wp-bootstrap-starter-robotoslab-roboto', 'https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Roboto:300,300i,400,400i,500,700,700i' );
         $parent_style[] ='wp-bootstrap-starter-robotoslab-roboto';
    }
    if(get_theme_mod( 'preset_style_setting' ) && get_theme_mod( 'preset_style_setting' ) !== 'default') {
        wp_enqueue_style( 'wp-bootstrap-starter-'.get_theme_mod( 'preset_style_setting' ), get_template_directory_uri() . '/inc/assets/css/presets/typography/'.get_theme_mod( 'preset_style_setting' ).'.css', false, '' );
         $parent_style[] ='wp-bootstrap-starter-'.get_theme_mod( 'preset_style_setting' );
    }
    
   
    
    //Color Scheme
    /*if(get_theme_mod( 'preset_color_scheme_setting' ) && get_theme_mod( 'preset_color_scheme_setting' ) !== 'default') {
        wp_enqueue_style( 'wp-bootstrap-starter-'.get_theme_mod( 'preset_color_scheme_setting' ), get_template_directory_uri() . '/inc/assets/css/presets/color-scheme/'.get_theme_mod( 'preset_color_scheme_setting' ).'.css', false, '' );
    }else {
        wp_enqueue_style( 'wp-bootstrap-starter-default', get_template_directory_uri() . '/inc/assets/css/presets/color-scheme/blue.css', false, '' );
    }*/
    
    
    
    

	wp_enqueue_script('jquery');

    // Internet Explorer HTML5 support
    wp_enqueue_script( 'html5hiv',get_template_directory_uri().'/inc/assets/js/html5.js', array(), '3.7.0', false );
    wp_script_add_data( 'html5hiv', 'conditional', 'lt IE 9' );

	// load bootstrap js
    wp_enqueue_script('wp-bootstrap-starter-popper', get_template_directory_uri() . '/inc/assets/js/popper.min.js', array(), '', true );
	wp_enqueue_script('wp-bootstrap-starter-bootstrapjs', get_template_directory_uri() . '/inc/assets/js/bootstrap.min.js', array(), '', true );
    wp_enqueue_script('wp-bootstrap-starter-themejs', get_template_directory_uri() . '/inc/assets/js/theme-script.min.js', array(), '', true );
	wp_enqueue_script( 'wp-bootstrap-starter-skip-link-focus-fix', get_template_directory_uri() . '/inc/assets/js/skip-link-focus-fix.min.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	  if(get_theme_mod( 'theme_option_setting-child' ) && get_theme_mod( 'theme_option_setting-child' ) !== 'default') {
        wp_enqueue_style( 
            'wp-bootstrap-starter-2'.get_theme_mod( 'theme_option_setting-child' ), 
            get_stylesheet_directory_uri() . '/inc/assets/css/presets/theme-option/'.get_theme_mod( 'theme_option_setting-child' ).'.css',
            array(),
            null);
     }
     

	
 wp_enqueue_style( 'wp-bootstrap-starter-child-style',  get_stylesheet_directory_uri().'/style.css', $parent_style,    wp_get_theme()->get('Version'));   
     


}
add_action('wp_enqueue_scripts','wp_bootstrap_starter_child_scripts');