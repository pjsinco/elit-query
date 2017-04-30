<?php
/*
Plugin Name: Elit Query
Plugin URI:  
Description: Display an author query in a post
Version: 0.1.0
Author: Patrick Sinco
Author URI: 
License: GPL2
*/


// if this file is called directly, abort
if (!defined('WPINC')) {
  die;
}


function elit_query_shortcode_init() {

  if ( ! shortcode_exists( 'query' ) ) {

    function elit_query_shortcode( $atts, $content ) {
      
      $shortcode_atts = shortcode_atts( array(
        'q' => '',
        'a' => '',
        'c' => ''
      ), $atts, 'query' );

      $new_content  = '<span class="elit-query">' . $content . '</span>';

      if ( ! empty( $q = $shortcode_atts['q'] )) {
        $new_content .= "<span class='elit-query__q'>$q</span>";
      }

      $filtered_content = apply_filters( 'elit_query', $new_content, $content );

      return $filtered_content;

      //return $new_content;
    }

    add_shortcode( 'query', 'elit_query_shortcode' );
  }
}

add_action('init' , 'elit_query_shortcode_init' );

function elit_query_enqueue_scripts() {

  $style_path = 'public/styles/elit-query.css';

  wp_enqueue_style(
    'elit-query-styles',
    plugins_url( $style_path, __FILE__ ),
    array(),
    filemtime( plugin_dir_path(__FILE__) . $style_path )
  );
}
add_action('wp_enqueue_scripts' , 'elit_query_enqueue_scripts');

/**
 * Show the regular output if the user is not logged in.
 *
 */
function elit_query_bail_or_not( $return, $tag, $attr, $m ) {

  if ( is_user_logged_in() ) {
    return false;
  }

  $content = isset( $m[5] ) ? $m[5] : null;

  return $content;

}
add_filter( 'pre_do_shortcode_tag',  'elit_query_bail_or_not', 10, 4 );
