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
             'key' => 'hard_rock_id',
             'value' => '',
             'compare' => '!='
         )
     )
  );

  $cities = get_posts( $args );

  if( empty( $cities ) ) {
    return null;
  }

  $hotel_cities = array();

  foreach($cities as $city) {
    $hardrock_id = get_field('hard_rock_id', $city->ID);

    $hotel_cities[] = array(
      '_id' => $city->ID,
      'displayName' => $city->post_title,
      'name' => $city->post_name,
      'hardRockId' => $hardrock_id
    );
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
