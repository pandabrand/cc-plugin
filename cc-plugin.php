<?php
/*
Plugin Name: Culture Collide Custom Post Types
Description: Custom Post Types for Culture Collide website.
Author: Frederick Wells
Author URI: http://www.pandabrand.net
*/

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

  include 'radip-addon.php';
  $cc_addon = new RapidAddon('CC Add-On', 'cc_addon');
  $cc_addon->add_acf_field('location_city');
  $cc_addon->set_import_function('my_addon_import_function');
  $my_addon->run(
  	array(
  		"post_types" => array( "location" ),
  	)
  );
  $my_addon->admin_notice(
    "This Add-On requires WP All Import and the Culture Collide theme.",
	array(
		"themes"  => array( "Sage Starter" ),
  	// "plugins" => array( "wp-all-export/wp-all-export.php" )
    )
  );

  function set_import_function($post_id, $data, $import_options, $article) {
    global $cc_addon;
    $fields = array(
      'location_city'
    );
    foreach ($fields as $field) {
      if($cc_addon->can_update_meta( 'location_city', $import_options ) ) {
        $city_posts = get_posts(array(
        	'numberposts' => 1,
        	'post_type' => 'city',
        	'meta_key' => 'migrate_id',
        	'meta_value' => $data['location_city_id']
        ));
        if(!empty($city_posts)) {
          $city_to_add = $city_posts[0];
          $cc_addon->log( '- Adding city to location by ID: ' . $city_to_add['ID'] );
          update_field('location_city', $city_to_add['ID']);
          //next level set the return relatioship
          $cc_addon->log( '- Adding return reference of location to city by ID: ' . $post_id );
          update_field('locations', $post_id, $city_to_add['ID']);
        }
      }
    }
  }
}
