<?php
function cc_rewrite_rule() {
  global $wp_query;
  write_log($wp_query->query_vars);
  add_rewrite_rule( '(^location-type)/([^/]+)/location-city/([^/]+)','base.php?pagename=$matches[0]&page=$matches[1]&location-city=$matches[2]', 'top' );
}

function cc_prefix_register_query_var( $vars ) {
  $vars[] = 'location-city';
  return $vars;
}

function cc_prefix_url_rewrite_templates() {
  // global $wp_query;
  write_log('redirecting...');
  // write_log($wp_query->query_vars);
  if ( get_query_var( 'location-city' ) && is_tax( 'location_types' ) ) {
    write_log('redirected...');
    add_filter( 'template_include', function() { return  get_template_directory() . '/taxonomy-location_types.php';});
  }
}

function cc_plugin_activate() {
 cc_rewrite_rule();
 flush_rewrite_rules();
}

function cc_plugin_deactivate() {
 flush_rewrite_rules();
}

function products_plugin_rules() {
 add_rewrite_rule('products/?([^/]*)', 'index.php?pagename=products&product_id=$matches[1]', 'top');
}

//register activation function
register_activation_hook(__FILE__, 'cc_plugin_activate');
//register deactivation function
register_deactivation_hook(__FILE__, 'cc_plugin_deactivate');

add_action('init', 'cc_rewrite_rule', 10, 0);
add_filter( 'query_vars', 'cc_prefix_register_query_var' );
add_action( 'template_redirect', 'cc_prefix_url_rewrite_templates' );
