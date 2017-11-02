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

function get_hrh_cities() {
  $args = array(
    'post_type' => ['city'],
    'meta_query' => array(
         array(
             'key' => 'field_596787798782e',
             'value' => '',
             'compare' => '!='
         )
     )
  );

  $hotel_cities = get_posts( $args );
  write_log($hotel_cities);

  if( empty( $hotel_cities ) ) {
    return null;
  }

  return $hotel_cities;
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

  register_rest_route( 'cc-api/v1', '/hotels/', array(
    'methods' => 'GET',
    'callback' => 'get_hrh_cities',
  ) );

} );
