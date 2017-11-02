<?php

function get_cities() {
  $cities = get_posts(array(
    'post_type' => ['cities']
  ));

  if( empty( $cities ) ) {
    return null;
  }

  return $cities;
}

add_action( 'cc-rest_api_init', function () {
  register_rest_route( 'cc-api/v1', '/cities/', array(
    'methods' => 'GET',
    'callback' => 'get_cities',
  ) );
} );
