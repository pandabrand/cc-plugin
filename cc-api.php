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

add_action( 'rest_api_init', function () {
  register_rest_route( 'cc-api/v1', '/cities/', array(
    'methods' => 'GET',
    'callback' => 'get_cities',
  ) );
} );
