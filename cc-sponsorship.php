<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_5979e6c108be8',
	'title' => 'Sponsorship Group',
	'fields' => array (
		array (
			'key' => 'field_5979e6f6b9602',
			'label' => 'Sponsor Title',
			'name' => 'sponsor_title',
			'type' => 'text',
			'instructions' => 'Title is fall back for Sponsorship, if there isn\'t a image or the image can\'t be found we will display the Sponsor Title(Name).',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'sponsor',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array (
			'key' => 'field_5979e71bb9603',
			'label' => 'Sponsor Logo',
			'name' => 'sponsor_logo',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => 'jpg, png, gif, jpeg',
		),
		array (
			'key' => 'field_5979e6f6b9602cczzz',
			'label' => 'Sponsor URL',
			'name' => 'sponsor_url',
			'type' => 'url',
			'instructions' => 'Sponsor URL',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'https://www.sponsor.net',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'city',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'artist',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
