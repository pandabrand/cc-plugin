<?php
/*
Plugin Name: Culture Collide Custom Post Types
Description: Custom Post Types for Culture Collide website.
Author: Frederick Wells
Author URI: http://www.pandabrand.net
*/
include "rapid-addon.php";

add_action( 'init', 'culture_collide_cpt' );

function culture_collide_cpt() {
  //City post type
  register_post_type( 'city', array(
    'labels' => array(
      'name' => 'Cities',
      'singular_name' => 'City',
      'menu_name' => 'City',
      'name_admin_bar' => 'City',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New City',
      'edit_item' => 'Edit City',
      'new_item' => 'New City',
      'view_item' => 'View City',
      'search_items' => 'Search Cities',
      'not_found' => 'No Cities found',
      'not_found_in_trash' => 'No Cities in the trash.',
      'all_items' => 'Cities',
     ),
    'description' => 'Cities are post types that will be used in the Travel section of the Culture Collide website. They will be responsible for linking Artists to their home city and the Locations.',
    'public' => true,
    'menu_position' => 2,
    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    'show_in_nav_menus' => true,
    'has_archive' => true
  ));

  //Artist post type
  register_post_type( 'artist', array(
    'labels' => array(
      'name' => 'Artists',
      'singular_name' => 'Artist',
      'menu_name' => 'Artist',
      'name_admin_bar' => 'Artist',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Artist',
      'edit_item' => 'Edit Artist',
      'new_item' => 'New Artist',
      'view_item' => 'View Artist',
      'search_items' => 'Search Artists',
      'not_found' => 'No Artists found',
      'not_found_in_trash' => 'No Artists in the trash.',
      'all_items' => 'Artists',
     ),
    'description' => 'Artists are post types that will be used in the Travel section of the Culture Collide website. Artists will have a City post type and will have multiple Locations.',
    'public' => true,
    'menu_position' => 2,
    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    'show_in_nav_menus' => true,
    'has_archive' => true
  ));

  //Location post type
  register_post_type( 'location', array(
    'labels' => array(
      'name' => 'Locations',
      'singular_name' => 'Location',
      'menu_name' => 'Location',
      'name_admin_bar' => 'Location',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Location',
      'edit_item' => 'Edit Location',
      'new_item' => 'New Location',
      'view_item' => 'View Location',
      'search_items' => 'Search Locations',
      'not_found' => 'No Locations found',
      'not_found_in_trash' => 'No Locations in the trash.',
      'all_items' => 'Locations',
     ),
    'description' => 'Locations are post types that will be used in the Travel section of the Culture Collide website. Locations will belong to a City post type and can be associated to multiple Artists.',
    'public' => true,
    'menu_position' => 2,
    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    'show_in_nav_menus' => true,
    'has_archive' => true
  ));
}

//Custom Categories for Locations
//hook into the init action and call create_locations_hierarchical_taxonomy when it fires
add_action( 'init', 'create_locations_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it Location Type for your Locations

function create_locations_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

  $labels = array(
    'name' => _x( 'Location Types', 'taxonomy general name' ),
    'singular_name' => _x( 'Location Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Location Types' ),
    'all_items' => __( 'All Location Types' ),
    'parent_item' => __( 'Parent Location Type' ),
    'parent_item_colon' => __( 'Parent Location Type:' ),
    'edit_item' => __( 'Edit Location Type' ),
    'update_item' => __( 'Update Location Type' ),
    'add_new_item' => __( 'Add New Location Type' ),
    'new_item_name' => __( 'New Location Type' ),
    'menu_name' => __( 'Location Types' ),
  );

// Now register the taxonomy

  register_taxonomy('location_types',array('location'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'location-type' ),
  ));

}

$cc_addon = new RapidAddon("CC Add-On","cc_addon");
$cc_addon->add_field("city_migrate_id", "City ID", "text");
$cc_addon->set_import_function("cc_addon_import_function");
$cc_addon->admin_notice(
  "This Add-On requires WP All Import and the Culture Collide theme.",
  array(
    "themes"  => array( "Sage Starter" )
    )
);
$cc_addon->run(
  array(
    "post_types" => array( "location" ),
  )
);

function cc_addon_import_function($post_id, $data, $import_options, $article) {
  write_log("starting import get city posts");
  $city_posts = get_posts(array(
    'numberposts' => 1,
    'post_type' => 'city',
    'meta_key' => 'migrate_id',
    'meta_value' => $data['city_migrate_id']
  ));
  write_log("city_posts retrieved : " . $city_posts[0]);
  if(!empty($city_posts)) {
    $city_to_add = $city_posts[0];
    write_log("city_posts not empty : " . $city_to_add['ID']);
    $cc_addon->log( "- Adding city to location by ID: " . $city_to_add['ID'] );
    update_field("location_city", $city_to_add['ID']);
    //next level set the return relatioship
    $cc_addon->log( "- Adding return reference of location to city by ID: " . $post_id );
    update_field("locations", $post_id, $city_to_add['ID']);
  }
}


if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}
