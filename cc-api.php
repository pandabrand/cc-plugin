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
    'name' => 'location-types'
  );

  $output = 'names';

  $categories = get_taxonomies( $args, $output );

  if ( empty( $categories ) ) {
    return null;
  }

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
