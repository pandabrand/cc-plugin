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

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_59678f2509069',
	'title' => 'Location Field Group',
	'fields' => array (
		array (
			'key' => 'field_59678f327c532',
			'label' => 'Address',
			'name' => 'address',
			'type' => 'google_map',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'center_lat' => '',
			'center_lng' => '',
			'zoom' => '',
			'height' => 200,
		),
		array (
			'key' => 'field_59678f517c533',
			'label' => 'Website',
			'name' => 'website',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array (
			'key' => 'field_59685c31a8fd6',
			'label' => 'Photo Credit',
			'name' => 'photo_credit',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array (
			'key' => 'field_5968371eb1dd1',
			'label' => 'Location City',
			'name' => 'location_city',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'city',
			),
			'taxonomy' => array (
			),
			'filters' => array (
				0 => 'search',
			),
			'elements' => '',
			'min' => '',
			'max' => '',
			'return_format' => 'id',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'location',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
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
  $city_id = $data['city_migrate_id'];
  write_log("starting import get city posts: " . $city_id);
  $city_posts = get_posts(array(
    'posts_per_page' => 1,
    'post_type' => 'city',
    'meta_query' => array(
        array(
          'key' => 'migrate_id',
          'value' => $city_id
        )
      )
  ));

  write_log("city_posts retrieved : " . $city_posts);
  if(!empty($city_posts)) {
    $city_to_add = $city_posts[0];
    write_log("city_posts not empty : " . $city_to_add->ID);
    $cc_addon->log( "- Adding city to location by ID: " . $city_to_add->ID );
    $field_obj = get_field_object('location_city', $post_id);
    write_log("field object: " . $field_obj["key"] . " : " . $field_obj["label"]);
    // update_field("location_city", $city_to_add->ID, $post_id);
    update_post_meta( $post_id, $field_obj["key"],$city_to_add->ID );
    //next level set the return relatioship
    write_log("Trying reverse assigment " );
    $cc_addon->log( "- Adding return reference of location to city by ID: " . $post_id );
    // update_field("locations", $post_id, $city_to_add->ID);
    $city_obj = get_field_object('locations', $city_to_add->ID);
    update_post_meta( $city_to_add->ID, $city_obj["key"], $post_id );
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
