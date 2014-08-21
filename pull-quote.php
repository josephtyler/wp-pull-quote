<?php
/**
 * Plugin Name: Pull Quote
 * Plugin URI: http://no-url.com
 * Description: Set text in the editor to be styled as a pull quote.
 * Version: 1.0
 * Author: Joseph Jones
 * Author URI: http://josephtylerjones.com
 * License: TJPL
 */

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
    // Define the style_formats array
    $style_formats = array(  
        // Each array child is a format with it's own settings
        array(  
            'title' => 'Pull Quote Left',  
            'block' => 'div',  
            'classes' => 'pull-quote  pull-quote-left',
            'wrapper' => true,
        ),
        array(  
            'title' => 'Pull Quote Right',  
            'block' => 'div',  
            'classes' => 'pull-quote  pull-quote-right',
            'wrapper' => true,
        ),
        array(  
            'title' => 'Pull Quote',  
            'block' => 'div',  
            'classes' => 'pull-quote pull-quote-center',
            'wrapper' => true,
        ),
        array(
            'title' => 'Pull Quote Author',
            'block' => 'div',
            'classes' => 'pull-quote-author',
            'wrapper' => true
        )
    );  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 

// Pull Quote Styles in editor
function my_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}


function editor_pull_quote_css( $mce_css ) {
    $mce_css .= ', ' . plugins_url( 'css/pull-quote.css', __FILE__ );
    return $mce_css;
}

/**
 * Proper way to enqueue scripts and styles
 */
function theme_name_scripts() {
    wp_register_style( 'pull-quote', plugins_url( 'css/pull-quote.css', __FILE__));
    wp_enqueue_style( 'pull-quote' );
    //wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}

// Register each action
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
add_filter( 'mce_css', 'editor_pull_quote_css' );
add_action( 'init', 'my_theme_add_editor_styles' );
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );  
add_filter('mce_buttons_2', 'my_mce_buttons_2');
