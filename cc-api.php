<?php

function get_cities() {
  $args = array(
    'post_type' => ['city']
  );

  $cities = get_posts($args);

  if( empty( $cities ) ) {
    return null;
  }

  return $cities;
}

function get_location_categories() {
  $args = array(
    'taxonomy' => 'location_types',
    'hide_empty' => true
  );

  $categories_terms = get_terms( $args );

  if ( empty( $categories_terms ) ) {
    return null;
  }

  $categories = wp_list_pluck( $categories_terms, 'name' );

  return $categories;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'cc-api/v1', '/cities/', array(
    'methods' => 'GET',
    'callback' => 'get_cities',
  ) );

  register_rest_route( 'cc-api/v1', '/categories/', array(
    'methods' => 'GET',
    'callback' => 'get_location_categories',
  ) );

} );
