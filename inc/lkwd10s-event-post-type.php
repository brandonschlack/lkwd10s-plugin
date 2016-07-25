<?php
/**
 * Event Post Type
 * Post Type
 *
 */

// Register Custom Post Type
function event_post_type() {

	$labels = array(
		'name'                  => 'Events',
		'singular_name'         => 'Event',
		'menu_name'             => 'Events',
		'name_admin_bar'        => 'Event',
		'archives'              => 'Event Archives',
		'parent_item_colon'     => 'Parent Event',
		'all_items'             => 'All Events',
		'add_new_item'          => 'Add New Event',
		'add_new'               => 'Add New',
		'new_item'              => 'New Event',
		'edit_item'             => 'Edit Event',
		'update_item'           => 'Update Event',
		'view_item'             => 'View Event',
		'search_items'          => 'Search Event',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into event',
		'uploaded_to_this_item' => 'Uploaded to this event',
		'items_list'            => 'Events list',
		'items_list_navigation' => 'Events list navigation',
		'filter_items_list'     => 'Filter events list',
	);
	$args = array(
		'label'                 => 'Event',
		'description'           => 'Event at Lakewood Tennis Center',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
		'taxonomies'            => array( 'event_type' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'event', $args );

}
add_action( 'init', 'event_post_type', 0 );


/**
 * Event Types
 * Custom Taxonomy
 *
 */

// Register Custom Taxonomy
function event_type_taxonomy() {

	$labels = array(
		'name'                       => 'Event Types',
		'singular_name'              => 'Event Type',
		'menu_name'                  => 'Event Type',
		'all_items'                  => 'All Event Types',
		'parent_item'                => 'Parent Event Type',
		'parent_item_colon'          => 'Parent Event Type:',
		'new_item_name'              => 'New Event Type Name',
		'add_new_item'               => 'Add New Event Type',
		'edit_item'                  => 'Edit Event Type',
		'update_item'                => 'Update Event Type',
		'view_item'                  => 'View Event Type',
		'separate_items_with_commas' => 'Separate event types with commas',
		'add_or_remove_items'        => 'Add or remove event types',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Event Types',
		'search_items'               => 'Search Event Types',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Event Types',
		'items_list'                 => 'Event Types list',
		'items_list_navigation'      => 'Event Types list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'event_type', array( 'event' ), $args );

}
add_action( 'init', 'event_type_taxonomy', 0 );


/**
 * Event Date
 * Meta Box
 *
 */

// Register Custom Meta Box
class Event_Date_Meta_Box {

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
			'event_date',
			'Event Dates',
			array( $this, 'render_metabox' ),
			'event',
			'normal',
			'default'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'event_date_nonce_action', 'event_date_nonce' );

		// Retrieve an existing value from the database.
		$event_date_start_date = get_post_meta( $post->ID, 'event_date_start_date', true );
		$event_date_end_date = get_post_meta( $post->ID, 'event_date_end_date', true );

		// Set default values.
		if( empty( $event_date_start_date ) ) $event_date_start_date = '';
		if( empty( $event_date_end_date ) ) $event_date_end_date = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="event_date_start_date" class="event_date_start_date_label">' . 'Start Date' . '</label></th>';
		echo '		<td>';
		echo '			<input type="date" id="event_date_start_date" name="event_date_start_date" class="event_date_start_date_field" placeholder="' . '' . '" value="' . esc_attr__( $event_date_start_date ) . '">';
		echo '			<p class="description">' . 'Start date for event' . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="event_date_end_date" class="event_date_end_date_label">' . 'End Date' . '</label></th>';
		echo '		<td>';
		echo '			<input type="date" id="event_date_end_date" name="event_date_end_date" class="event_date_end_date_field" placeholder="' . '' . '" value="' . esc_attr__( $event_date_end_date ) . '">';
		echo '			<p class="description">' . 'End date for event' . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['event_date_nonce'] ) ? $_POST['event_date_nonce'] : '';
		$nonce_action = 'event_date_nonce_action';

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
		$event_date_new_start_date = isset( $_POST[ 'event_date_start_date' ] ) ? sanitize_text_field( $_POST[ 'event_date_start_date' ] ) : '';
		$event_date_new_end_date = isset( $_POST[ 'event_date_end_date' ] ) ? sanitize_text_field( $_POST[ 'event_date_end_date' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'event_date_start_date', $event_date_new_start_date );
		update_post_meta( $post_id, 'event_date_end_date', $event_date_new_end_date );

	}

}

new Event_Date_Meta_Box;


/**
 * Event Tournament Info
 * Meta Box
 *
 */

// Register Custom Meta Box
class Event_Tourn_Meta_Box {

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
			'event_tourn',
			'Tournament Info',
			array( $this, 'render_metabox' ),
			'event',
			'normal',
			'default'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'event_tourn_nonce_action', 'event_tourn_nonce' );

		// Retrieve an existing value from the database.
		$event_tourn_tourn_id = get_post_meta( $post->ID, 'event_tourn_tourn_id', true );
		$event_tourn_tourn_home_link = get_post_meta( $post->ID, 'event_tourn_tourn_home_link', true );

		// Set default values.
		if( empty( $event_tourn_tourn_id ) ) $event_tourn_tourn_id = '';
		if( empty( $event_tourn_tourn_home_link ) ) $event_tourn_tourn_home_link = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="event_tourn_tourn_id" class="event_tourn_tourn_id_label">' . 'Tournament ID' . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="event_tourn_tourn_id" name="event_tourn_tourn_id" class="event_tourn_tourn_id_field" placeholder="' . '' . '" value="' . esc_attr__( $event_tourn_tourn_id ) . '">';
		echo '			<p class="description">' . 'USTA TennisLink Tournament ID number' . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="event_tourn_tourn_home_link" class="event_tourn_tourn_home_link_label">' . 'Tournament Home Link' . '</label></th>';
		echo '		<td>';
		echo '			<input type="url" id="event_tourn_tourn_home_link" name="event_tourn_tourn_home_link" class="event_tourn_tourn_home_link_field" placeholder="' . '' . '" value="' . esc_attr__( $event_tourn_tourn_home_link ) . '">';
		echo '			<p class="description">' . 'Link to the Tournament Home page created by USTA TennisLink' . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['event_tourn_nonce'] ) ? $_POST['event_tourn_nonce'] : '';
		$nonce_action = 'event_tourn_nonce_action';

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
		$event_tourn_new_tourn_id = isset( $_POST[ 'event_tourn_tourn_id' ] ) ? sanitize_text_field( $_POST[ 'event_tourn_tourn_id' ] ) : '';
		$event_tourn_new_tourn_home_link = isset( $_POST[ 'event_tourn_tourn_home_link' ] ) ? esc_url( $_POST[ 'event_tourn_tourn_home_link' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'event_tourn_tourn_id', $event_tourn_new_tourn_id );
		update_post_meta( $post_id, 'event_tourn_tourn_home_link', $event_tourn_new_tourn_home_link );

	}

}

new Event_Tourn_Meta_Box;
