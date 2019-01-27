<?php
/**
 * WP Bootstrap Starter Child Theme Customizer
 *
 * @package WP_Bootstrap_Starter_Child
 */

 function wp_bootstrap_starter_child_customizer_settings($wp_customize) {
     
 $wp_customize->add_setting( 'theme_option_setting-child', array(
        'default'   => 'default',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );
   

 $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'theme_option_setting-child', array(
        'label' => __( 'Studysnami options', 'wp-bootstrap-starter' ),
        'section'    => 'typography',
        'settings'   => 'theme_option_setting-child',
        'type'    => 'select',
        'choices' => array(
            'default' => 'Default',
            'red_white_base' => 'Red-white base',
            'option2' => 'option2',
            'option3' => 'option3',
            'option4' => 'option4',
            'option5' => 'option5',
            'option6' => 'option6'
        )
    ) ) );


}

 
add_action('customize_register', 'wp_bootstrap_starter_child_customizer_settings');


