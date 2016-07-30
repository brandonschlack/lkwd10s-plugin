<?php
/**
 * Teaching Pro Post Type
 * Post Type
 *
 */

// Register Custom Post Type
function teaching_pro_post_type() {

	$labels = array(
		'name'                  => 'Teaching Pros',
		'singular_name'         => 'Teaching Pro',
		'menu_name'             => 'Teaching Pros',
		'name_admin_bar'        => 'Teaching Pro',
		'archives'              => 'Teaching Pro Archives',
		'parent_item_colon'     => 'Parent Teaching Pro:',
		'all_items'             => 'All Teaching Pros',
		'add_new_item'          => 'Add New Teaching Pro',
		'add_new'               => 'Add New Teaching Pro',
		'new_item'              => 'New Teaching Pro',
		'edit_item'             => 'Edit Teaching Pro',
		'update_item'           => 'Update Teaching Pro',
		'view_item'             => 'View Teaching Pro',
		'search_items'          => 'Search Teaching Pro',
		'not_found'             => 'Teaching Pro Not Found',
		'not_found_in_trash'    => 'Teaching Pro Not Found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into profile',
		'uploaded_to_this_item' => 'Uploaded to this profile',
		'items_list'            => 'Teaching Pros list',
		'items_list_navigation' => 'Teaching Pros list navigation',
		'filter_items_list'     => 'Filter teaching pros list',
	);
	$args = array(
		'label'                 => 'Teaching Pro',
		'description'           => 'Teaching Pro Profile',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'post-formats', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-id-alt',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'teaching_pro', $args );

}
add_action( 'init', 'teaching_pro_post_type', 0 );


/**
 * Teaching Pro Portrait
 * Meta Box
 *
 */

// Register Custom Meta Box
