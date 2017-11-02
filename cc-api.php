<?php
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

function get_locations_by_hotel_id( $data ) {
  //find hotel id, if none return null
  $hotel_id = $data['hotelId'];

  if( empty( $hotel_id ) ) {
    return null;
  }

  //find city by hotel ID
  $cities = get_posts( array(
    'post_type' => ['city'],
    'meta_query' => array(
       array(
           'key' => 'hard_rock_id',
           'value' => $hotel_id,
           'compare' => '='
       )
     )
  ) );

  //assumign first city is the city we need because there should be multiple
  $city = $cities[0];

  if( empty( $city ) ) {
    return null;
  }

  $locations = get_posts( array(
    'post_type' => ['location'],
    'meta_query' => array(
       array(
           'key' => 'location_city',
           'value' => '"' . $city->ID . '"',
           'compare' => 'LIKE'
       )
     )
  ) );

  $hrh_locations = array();
  $image_sizes = get_intermediate_image_sizes();

  foreach( $locations as $location ) {
    $photo = get_the_post_thumbnail_url( $location->ID, 'full' );
    $available_sizes = wp_get_attachment_image_src( $location->ID, $image_sizes );
    $location_terms = get_the_terms( $location->ID, 'location_types' );
    $location_tags = wp_list_pluck( $location_terms, 'name' );
    $website = get_field('website', $location->ID);
    $address = get_field('address', $location->ID);

    $hrh_locations[] = array(
      '_id'             => $location->ID,
      'name'            => $location->post_title,
      'description'     => $location->post_content,
      'photo'           => $photo,
      'available_sizes' => $available_sizes,
      'type'            => $location_tags,
      'website'         => $website,
      'address'         => $address
    );
  }

  return $hrh_locations;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'cc-api/v1', '/categories/', array(
    'methods' => 'GET',
    'callback' => 'get_location_categories',
  ) );

  register_rest_route( 'cc-api/v1', '/hotels/', array(
    'methods' => 'GET',
    'callback' => 'get_hrh_cities',
  ) );

  register_rest_route( 'cc-api/v1', '/locations/(?P<hotelId>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_locations_by_hotel_id',
  ) );

} );
