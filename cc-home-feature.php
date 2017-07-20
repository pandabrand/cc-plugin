<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_5971019886bce',
	'title' => 'Home Feature Pages',
	'fields' => array (
		array (
			'key' => 'field_597101a33a8ba',
			'label' => 'Main Feature',
			'name' => 'main_feature',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'post',
				1 => 'city',
				2 => 'artist',
				3 => 'event',
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array (
			'key' => 'field_597101e63a8bb',
			'label' => 'Secondary Main Feature',
			'name' => 'secondary_main_feature',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 3,
			'layout' => 'row',
			'button_label' => 'Add Feature',
			'sub_fields' => array (
				array (
					'key' => 'field_5971024e3a8bc',
					'label' => 'Feature Object',
					'name' => 'feature_object',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array (
						0 => 'post',
						1 => 'city',
						2 => 'artist',
						3 => 'event',
					),
					'taxonomy' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'page',
				'operator' => '==',
				'value' => '5543',
			),
			array (
				'param' => 'page',
				'operator' => '==',
				'value' => '9961',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
