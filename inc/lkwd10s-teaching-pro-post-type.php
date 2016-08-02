<?php
/**
 * Teaching Pro Post Type that defines a Teaching Pro for Lakewood Tennis Center.
 *
 * Registers the custom 'teaching_pro' post type
 *
 * @package: Lakewood_Tennis_Center_Plugin
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
class Teaching_Pro_Meta_Box {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes',        array( $this, 'add_metabox' )         );
		add_action( 'save_post',             array( $this, 'save_metabox' ), 10, 2 );


	}

	public function add_metabox() {

		add_meta_box(
			'teaching_pro',
			'Portrait',
			array( $this, 'render_metabox' ),
			'teaching_pro',
			'advanced',
			'high'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'teaching_pro_nonce_action', 'teaching_pro_nonce' );

		// Retrieve an existing value from the database.
		$teaching_pro_portrait = get_post_meta( $post->ID, 'teaching_pro_portrait', true );

		// Set default values.
		if( empty( $teaching_pro_portrait ) ) $teaching_pro_portrait = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="teaching_pro_portrait" class="teaching_pro_portrait_label">' . 'Portrait Image' . '</label></th>';
		echo '		<td>';
		echo '			<input type="url" id="teaching_pro_portrait" name="teaching_pro_portrait" class="teaching_pro_portrait_field" placeholder="' . 'Add Image' . '" value="' . esc_attr__( $teaching_pro_portrait ) . '">';
		echo '			<p class="description">' . 'Add a portrait or logo' . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['teaching_pro_nonce'] ) ? $_POST['teaching_pro_nonce'] : '';
		$nonce_action = 'teaching_pro_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// Sanitize user input.
		$teaching_pro_new_portrait = isset( $_POST[ 'teaching_pro_portrait' ] ) ? esc_url( $_POST[ 'teaching_pro_portrait' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'teaching_pro_portrait', $teaching_pro_new_portrait );

	}

}

new Teaching_Pro_Meta_Box;
