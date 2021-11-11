<?php
/**
 * Plugin Name: Kebbet plugins - Custom Post Type: Supporters
 * Plugin URI:  https://github.com/kebbet/kebbet-cpt-supporters
 * Description: Registers a Custom Post Type.
 * Version:     20210705.01
 * Author:      Erik Betshammar
 * Author URI:  https://verkan.se
 *
 * @package kebbet-cpt-supporters
 * @author Erik Betshammar
*/

namespace cpt\kebbet\supporters;

const POSTTYPE    = 'supporters';
const SLUG        = 'supoorter';
const ICON        = 'groups';
const MENUPOS     = 28;
const THUMBNAIL   = true;
const ARCHIVE_OPT = false;

/**
 * Link to ICONS
 *
 * @link https://developer.wordpress.org/resource/dashicons/
 */

/**
 * Hook into the 'init' action
 */
function init() {
	load_textdomain();
	register();
	if ( true === THUMBNAIL ) {
		add_theme_support( 'post-thumbnails' );
	}
}
add_action( 'init', __NAMESPACE__ . '\init', 0 );

/**
 * Flush rewrite rules on registration.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */
function rewrite_flush() {
	// First, we "add" the custom post type via the above written function.
	// Note: "add" is written with quotes, as CPTs don't get added to the DB,
	// They are only referenced in the post_type column with a post entry,
	// when you add a post of this CPT.
	register();

	// ATTENTION: This is *only* done during plugin activation hook in this example!
	// You should *NEVER EVER* do this on every page load!!
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\rewrite_flush' );

/**
 * Load plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'kebbet-cpt-supporters', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register Custom Post Type
 */
function register() {

	$labels_args       = array(
		'name'                     => _x( 'Supporters', 'Post Type General Name', 'kebbet-cpt-supporters' ),
		'singular_name'            => _x( 'Supporter', 'Post Type Singular Name', 'kebbet-cpt-supporters' ),
		'menu_name'                => __( 'Supporters', 'kebbet-cpt-supporters' ),
		'name_admin_bar'           => __( 'Supporter', 'kebbet-cpt-supporters' ),
		'all_items'                => __( 'All supporters', 'kebbet-cpt-supporters' ),
		'add_new_item'             => __( 'New supporter', 'kebbet-cpt-supporters' ),
		'add_new'                  => __( 'Add new supporter', 'kebbet-cpt-supporters' ),
		'new_item'                 => __( 'New supporter', 'kebbet-cpt-supporters' ),
		'edit_item'                => __( 'Edit supporter', 'kebbet-cpt-supporters' ),
		'update_item'              => __( 'Update supporter', 'kebbet-cpt-supporters' ),
		'view_item'                => __( 'View supporter', 'kebbet-cpt-supporters' ),
		'view_items'               => __( 'View supporters', 'kebbet-cpt-supporters' ),
		'search_items'             => __( 'Search supporters', 'kebbet-cpt-supporters' ),
		'not_found'                => __( 'Not found', 'kebbet-cpt-supporters' ),
		'not_found_in_trash'       => __( 'No supporters found in Trash', 'kebbet-cpt-supporters' ),
		'featured_image'           => __( 'Supporter logo', 'kebbet-cpt-supporters' ),
		'set_featured_image'       => __( 'Set supporter logo', 'kebbet-cpt-supporters' ),
		'remove_featured_image'    => __( 'Remove supporter logo', 'kebbet-cpt-supporters' ),
		'use_featured_image'       => __( 'Use as supporter logo', 'kebbet-cpt-supporters' ),
		'insert_into_item'         => __( 'Insert into item', 'kebbet-cpt-supporters' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this supporter', 'kebbet-cpt-supporters' ),
		'items_list'               => __( 'Items list', 'kebbet-cpt-supporters' ),
		'items_list_navigation'    => __( 'Items list navigation', 'kebbet-cpt-supporters' ),
		'filter_items_list'        => __( 'Filter items list', 'kebbet-cpt-supporters' ),
		'item_published'           => __( 'Supporter published', 'kebbet-cpt-supporters' ),
		'item_published_privately' => __( 'Supporter published privately', 'kebbet-cpt-supporters' ),
		'item_reverted_to_draft'   => __( 'Supporter reverted to Draft', 'kebbet-cpt-supporters' ),
		'item_scheduled'           => __( 'Supporter scheduled', 'kebbet-cpt-supporters' ),
		'item_updated'             => __( 'Supporter updated', 'kebbet-cpt-supporters' ),
		// 5.7 + 5.8
		'filter_by_date'           => __( 'Filter supporters by date', 'kebbet-cpt-supporters' ),
		'item_link'                => __( 'Supporters post link', 'kebbet-cpt-supporters' ),
		'item_link_description'    => __( 'A link to a supporters post', 'kebbet-cpt-supporters' ),
	);

	$supports_args = array(
		'title',
	);

	if ( true === THUMBNAIL ) {
		$supports_args = array_merge( $supports_args, array( 'thumbnail' ) );
	}

	$capabilities_args = array(
		'edit_post'          => 'edit_' . POSTTYPE,
		'edit_posts'         => 'edit_' . POSTTYPE .'s',
		'edit_others_posts'  => 'edit_others_' . POSTTYPE .'s',
		'publish_posts'      => 'publish_' . POSTTYPE .'s',
		'read_post'          => 'read_' . POSTTYPE .'s',
		'read_private_posts' => 'read_private_' . POSTTYPE .'s',
		'delete_post'        => 'delete_' . POSTTYPE,
	);
	$post_type_args    = array(
		'label'               => __( 'Supporters post type', 'kebbet-cpt-supporters' ),
		'description'         => __( 'Custom post type for Supporters', 'kebbet-cpt-supporters' ),
		'labels'              => $labels_args,
		'supports'            => $supports_args,
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => MENUPOS,
		'menu_icon'           => 'dashicons-' . ICON,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => false,
		'capabilities'        => $capabilities_args,
		// Adding map_meta_cap will map the meta correctly.
		'show_in_rest'        => true,
		'map_meta_cap'        => true,
	);
	register_post_type( POSTTYPE, $post_type_args );
}

/**
 * Adds custom capabilities to CPT. Adjust it with plugin URE later with its UI.
 */
function add_custom_capabilities() {

	// Gets the editor and administrator roles.
	$admins = get_role( 'administrator' );
	$editor = get_role( 'editor' );

	// Add custom capabilities.
	$admins->add_cap( 'edit_' . POSTTYPE );
	$admins->add_cap( 'edit_' . POSTTYPE .'s' );
	$admins->add_cap( 'edit_others_' . POSTTYPE .'s' );
	$admins->add_cap( 'publish_' . POSTTYPE .'s' );
	$admins->add_cap( 'read_' . POSTTYPE .'s' );
	$admins->add_cap( 'read_private_' . POSTTYPE .'s' );
	$admins->add_cap( 'delete_' . POSTTYPE );

	$editor->add_cap( 'edit_' . POSTTYPE );
	$editor->add_cap( 'edit_' . POSTTYPE .'s' );
	$editor->add_cap( 'edit_others_' . POSTTYPE .'s' );
	$editor->add_cap( 'publish_' . POSTTYPE .'s' );
	$editor->add_cap( 'read_' . POSTTYPE .'s' );
	$editor->add_cap( 'read_private_' . POSTTYPE .'s' );
	$editor->add_cap( 'delete_' . POSTTYPE );
}
add_action( 'admin_init', __NAMESPACE__ . '\add_custom_capabilities');

/**
 * Post type update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function post_updated_messages( $messages ) {

	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages[ POSTTYPE ] = array(
		0  => '',
		1  => __( 'Supporter updated.', 'kebbet-cpt-supporters' ),
		2  => __( 'Custom field updated.', 'kebbet-cpt-supporters' ),
		3  => __( 'Custom field deleted.', 'kebbet-cpt-supporters' ),
		4  => __( 'Supporter updated.', 'kebbet-cpt-supporters' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Supporter restored to revision from %s', 'kebbet-cpt-supporters' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Supporter published.', 'kebbet-cpt-supporters' ),
		7  => __( 'Supporter saved.', 'kebbet-cpt-supporters' ),
		8  => __( 'Supporter submitted.', 'kebbet-cpt-supporters' ),
		9  => sprintf(
			/* translators: %1$s: date and time of the scheduled post */
			__( 'Supporter scheduled for: <strong>%1$s</strong>.', 'kebbet-cpt-supporters' ),
			date_i18n( __( 'M j, Y @ G:i', 'kebbet-cpt-supporters' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Supporter draft updated.', 'kebbet-cpt-supporters' ),
	);
	if ( $post_type_object->publicly_queryable && POSTTYPE === $post_type ) {

		$permalink         = get_permalink( $post->ID );
		$view_link         = sprintf(
			' <a href="%s">%s</a>',
			esc_url( $permalink ),
			__( 'View Supporter', 'kebbet-cpt-supporters' )
		);
		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link      = sprintf(
			' <a target="_blank" href="%s">%s</a>',
			esc_url( $preview_permalink ),
			__( 'Preview Supporter', 'kebbet-cpt-supporters' )
		);

		$messages[ $post_type ][1]  .= $view_link;
		$messages[ $post_type ][6]  .= $view_link;
		$messages[ $post_type ][9]  .= $view_link;
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;

	}

	return $messages;

}
add_filter( 'post_updated_messages', __NAMESPACE__ . '\post_updated_messages' );

/**
 * Custom bulk post updates messages
 *
 * @param array  $bulk_messages The messages for bulk updating posts.
 * @param string $bulk_counts Number of updated posts.
 */
function bulk_post_updated_messages( $bulk_messages, $bulk_counts ) {

	$bulk_messages[ POSTTYPE ] = array(
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'updated'   => _n( '%$1s post updated.', '%$2s posts updated.', $bulk_counts['updated'], 'kebbet-cpt-supporters' ),
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'locked'    => _n( '%$1s post not updated, somebody is editing it.', '%$2s posts not updated, somebody is editing them.', $bulk_counts['locked'], 'kebbet-cpt-supporters' ),
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'deleted'   => _n( '%$1s post permanently deleted.', '%$2s posts permanently deleted.', $bulk_counts['deleted'], 'kebbet-cpt-supporters' ),
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'trashed'   => _n( '%$1s post moved to the Trash.', '%$2s posts moved to the Trash.', $bulk_counts['trashed'], 'kebbet-cpt-supporters' ),
		/* translators: %$1s: singular of posts, %$2s: plural of posts.  */
		'untrashed' => _n( '%$1s post restored from the Trash.', '%$2s posts restored from the Trash.', $bulk_counts['untrashed'], 'kebbet-cpt-supporters' ),
	);

	return $bulk_messages;

}
add_filter( 'bulk_post_updated_messages', __NAMESPACE__ . '\bulk_post_updated_messages', 10, 2 );

/**
 * Add the content to the `At a glance`-widget.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/at-a-glance.php';

/**
 * Adds and modifies the admin columns for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-columns.php';

/**
 * Add an option page for the post type.
 */
function add_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_sub_page( array(
			'page_title' => __( 'Supporters archive settings', 'kebbet-cpt-supporters' ),
			'menu_title' => __( 'Archive settings for Supporters', 'kebbet-cpt-supporters' ),
			'parent'     => 'edit.php?post_type=' . POSTTYPE,
			'post_id'    => POSTTYPE,
		) );
	}
}

if ( true === ARCHIVE_OPT ) {
	add_action( 'plugins_loaded', __NAMESPACE__ . '\add_options_page' );
}
