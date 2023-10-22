<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
require_once __DIR__ . '/vendor/autoload.php';
error_log('Autoloader included');
error_log(print_r(class_exists('\Timber\Timber'), true));

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */

if ( class_exists( 'Timber' ) ) {
    Timber::$dirname = array( 'templates', 'views' );
} else {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin.</p></div>';
    });
	return;
}

function add_theme_scripts() {

	wp_enqueue_style( 'fancy-style', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', array(), '1.1', 'all' );

	wp_enqueue_script( 'fancy-script', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array( 'jquery' ), 1.1, true );

}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Reusable Blocks',
		'menu_title'	=> 'Reusable Blocks',
		'menu_slug' 	=> 'theme-reusable-blocks',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

// Function to change system from: email address
function wpb_sender_email( $original_email_address ) {
    return 'info@incrementumdigital.com';
}

// Function to change system email sender name
function wpb_sender_name( $original_email_from ) {
    return 'Incrementum Digital';
}

// Hooking up our functions to WordPress filters
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'custom_sidebars' ) );
		// add_action( 'widgets_init', 'custom_widgets_init' );
		// add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {

		// Register Team Custom Post Type
		$labels = array(
			'name'                  => _x( 'Team Members', 'Post Type General Name', 'id' ),
			'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'id' ),
			'menu_name'             => __( 'Team', 'id' ),
			'name_admin_bar'        => __( 'Team Members', 'id' ),
			'archives'              => __( 'Team Archives', 'id' ),
			'attributes'            => __( 'Team Member Attributes', 'id' ),
			'parent_item_colon'     => __( 'Parent Item:', 'id' ),
			'all_items'             => __( 'All Team Members', 'id' ),
			'add_new_item'          => __( 'Add New Team Member', 'id' ),
			'add_new'               => __( 'Add New', 'id' ),
			'new_item'              => __( 'New Team Member', 'id' ),
			'edit_item'             => __( 'Edit Team Member', 'id' ),
			'update_item'           => __( 'Update Team Member', 'id' ),
			'view_item'             => __( 'View Team Member', 'id' ),
			'view_items'            => __( 'View Team Members', 'id' ),
			'search_items'          => __( 'Search Team Members', 'id' ),
			'not_found'             => __( 'Not found', 'id' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'id' ),
			'featured_image'        => __( 'Featured Image', 'id' ),
			'set_featured_image'    => __( 'Set featured image', 'id' ),
			'remove_featured_image' => __( 'Remove featured image', 'id' ),
			'use_featured_image'    => __( 'Use as featured image', 'id' ),
			'insert_into_item'      => __( 'Insert into Team Member', 'id' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'id' ),
			'items_list'            => __( 'Team list', 'id' ),
			'items_list_navigation' => __( 'Team list navigation', 'id' ),
			'filter_items_list'     => __( 'Filter Team list', 'id' ),
		);
		$rewrite = array(
			'slug'                  => 'team',
			'with_front'            => false,
			'pages'                 => true,
			'feeds'                 => false,
		);
		$args = array(
			'label'                 => __( 'Team', 'id' ),
			'description'           => __( 'Background and photos', 'id' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-id',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'				=> $rewrite,
			'capability_type'       => 'page',
		);
		register_post_type( 'team', $args );

		// Register Work Custom Post Type
		$labels = array(
			'name'                  => _x( 'Work', 'Post Type General Name', 'id' ),
			'singular_name'         => _x( 'Work', 'Post Type Singular Name', 'id' ),
			'menu_name'             => __( 'Work', 'id' ),
			'name_admin_bar'        => __( 'Work', 'id' ),
			'archives'              => __( 'Work Archives', 'id' ),
			'attributes'            => __( 'Work Attributes', 'id' ),
			'parent_item_colon'     => __( 'Parent Item:', 'id' ),
			'all_items'             => __( 'All Work', 'id' ),
			'add_new_item'          => __( 'Add New Work', 'id' ),
			'add_new'               => __( 'Add New', 'id' ),
			'new_item'              => __( 'New Work', 'id' ),
			'edit_item'             => __( 'Edit Work', 'id' ),
			'update_item'           => __( 'Update Work', 'id' ),
			'view_item'             => __( 'View Work', 'id' ),
			'view_items'            => __( 'View Work', 'id' ),
			'search_items'          => __( 'Search Work', 'id' ),
			'not_found'             => __( 'Not found', 'id' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'id' ),
			'featured_image'        => __( 'Featured Image', 'id' ),
			'set_featured_image'    => __( 'Set featured image', 'id' ),
			'remove_featured_image' => __( 'Remove featured image', 'id' ),
			'use_featured_image'    => __( 'Use as featured image', 'id' ),
			'insert_into_item'      => __( 'Insert into Work', 'id' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'id' ),
			'items_list'            => __( 'Work list', 'id' ),
			'items_list_navigation' => __( 'Work list navigation', 'id' ),
			'filter_items_list'     => __( 'Filter Work list', 'id' ),
		);
		$rewrite = array(
			'slug'                  => 'work',
			'with_front'            => false,
			'pages'                 => true,
			'feeds'                 => false,
		);
		$args = array(
			'label'                 => __( 'Work', 'id' ),
			'description'           => __( 'Background and photos', 'id' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-media-interactive',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'				=> $rewrite,
			'capability_type'       => 'page',
		);
		register_post_type( 'work', $args );

		// Register  Case Studies Post Type
		$labels = array(
			'name'                  => _x( 'Case Studies', 'Post Type General Name', 'id' ),
			'singular_name'         => _x( 'Case Study', 'Post Type Singular Name', 'id' ),
			'menu_name'             => __( 'Case Studies', 'id' ),
			'name_admin_bar'        => __( 'Case Studies', 'id' ),
			'archives'              => __( 'Case Study Archives', 'id' ),
			'attributes'            => __( 'Case Study Attributes', 'id' ),
			'parent_item_colon'     => __( 'Parent Item:', 'id' ),
			'all_items'             => __( 'All Case Studies', 'id' ),
			'add_new_item'          => __( 'Add New Case Study', 'id' ),
			'add_new'               => __( 'Add New', 'id' ),
			'new_item'              => __( 'New Case Study', 'id' ),
			'edit_item'             => __( 'Edit Case Study', 'id' ),
			'update_item'           => __( 'Update Case Study', 'id' ),
			'view_item'             => __( 'View Case Study', 'id' ),
			'view_items'            => __( 'View Case Studies', 'id' ),
			'search_items'          => __( 'Search Case Studies', 'id' ),
			'not_found'             => __( 'Not found', 'id' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'id' ),
			'featured_image'        => __( 'Featured Image', 'id' ),
			'set_featured_image'    => __( 'Set featured image', 'id' ),
			'remove_featured_image' => __( 'Remove featured image', 'id' ),
			'use_featured_image'    => __( 'Use as featured image', 'id' ),
			'insert_into_item'      => __( 'Insert into Case Study', 'id' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'id' ),
			'items_list'            => __( 'Case Study list', 'id' ),
			'items_list_navigation' => __( 'Case Study list navigation', 'id' ),
			'filter_items_list'     => __( 'Filter Case Study list', 'id' ),
		);
		$rewrite = array(
			'slug'                  => 'case-studies',
			'with_front'            => false,
			'pages'                 => true,
			'feeds'                 => false,
		);

		$args = array(
			'label'                 => __( 'Case Studies', 'id' ),
			'description'           => __( 'Background and photos', 'id' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-media-interactive',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'				=> $rewrite,
			'capability_type'       => 'page',
		);
		register_post_type( 'case-studies', $args );

		// Register  Review Post Type
		$labels = array(
			'name'                  => _x( 'Reviews', 'Post Type General Name', 'id' ),
			'singular_name'         => _x( 'Review', 'Post Type Singular Name', 'id' ),
			'menu_name'             => __( 'Reviews', 'id' ),
			'name_admin_bar'        => __( 'Reviews', 'id' ),
			'archives'              => __( 'Review Archives', 'id' ),
			'attributes'            => __( 'Review Attributes', 'id' ),
			'parent_item_colon'     => __( 'Parent Item:', 'id' ),
			'all_items'             => __( 'All Reviews', 'id' ),
			'add_new_item'          => __( 'Add New Review', 'id' ),
			'add_new'               => __( 'Add New', 'id' ),
			'new_item'              => __( 'New Review', 'id' ),
			'edit_item'             => __( 'Edit Review', 'id' ),
			'update_item'           => __( 'Update Review', 'id' ),
			'view_item'             => __( 'View Review', 'id' ),
			'view_items'            => __( 'View Review', 'id' ),
			'search_items'          => __( 'Search Reviews', 'id' ),
			'not_found'             => __( 'Not found', 'id' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'id' ),
			'featured_image'        => __( 'Featured Image', 'id' ),
			'set_featured_image'    => __( 'Set featured image', 'id' ),
			'remove_featured_image' => __( 'Remove featured image', 'id' ),
			'use_featured_image'    => __( 'Use as featured image', 'id' ),
			'insert_into_item'      => __( 'Insert into Review', 'id' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'id' ),
			'items_list'            => __( 'Review list', 'id' ),
			'items_list_navigation' => __( 'Review list navigation', 'id' ),
			'filter_items_list'     => __( 'Filter Review list', 'id' ),
		);
		$rewrite = array(
			'slug'                  => 'reviews',
			'with_front'            => false,
			'pages'                 => true,
			'feeds'                 => false,
		);

		$args = array(
			'label'                 => __( 'Reviews', 'id' ),
			'description'           => __( 'Reviews', 'id' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-superhero-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'				=> $rewrite,
			'capability_type'       => 'post',
		);
		register_post_type( 'reviews', $args );

		// Register Podcast Custom Post Type
		$labels = array(
			'name'                  => _x( 'Podcast', 'Post Type General Name', 'id' ),
			'singular_name'         => _x( 'Podcast', 'Post Type Singular Name', 'id' ),
			'menu_name'             => __( 'Podcast', 'id' ),
			'name_admin_bar'        => __( 'Podcast', 'id' ),
			'archives'              => __( 'Podcast Archives', 'id' ),
			'attributes'            => __( 'Podcast Attributes', 'id' ),
			'parent_item_colon'     => __( 'Parent Item:', 'id' ),
			'all_items'             => __( 'All Podcasts', 'id' ),
			'add_new_item'          => __( 'Add New Podcast', 'id' ),
			'add_new'               => __( 'Add New', 'id' ),
			'new_item'              => __( 'New Podcast', 'id' ),
			'edit_item'             => __( 'Edit Podcast', 'id' ),
			'update_item'           => __( 'Update Podcast', 'id' ),
			'view_item'             => __( 'View Podcast', 'id' ),
			'view_items'            => __( 'View Podcast', 'id' ),
			'search_items'          => __( 'Search Podcast', 'id' ),
			'not_found'             => __( 'Not found', 'id' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'id' ),
			'featured_image'        => __( 'Featured Image', 'id' ),
			'set_featured_image'    => __( 'Set featured image', 'id' ),
			'remove_featured_image' => __( 'Remove featured image', 'id' ),
			'use_featured_image'    => __( 'Use as featured image', 'id' ),
			'insert_into_item'      => __( 'Insert into Podcast', 'id' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'id' ),
			'items_list'            => __( 'Podcast list', 'id' ),
			'items_list_navigation' => __( 'Podcast list navigation', 'id' ),
			'filter_items_list'     => __( 'Filter Podcast list', 'id' ),
		);
		$rewrite = array(
			'slug'                  => 'podcast',
			'with_front'            => false,
			'pages'                 => true,
			'feeds'                 => false,
		);
		$args = array(
			'label'                 => __( 'Podcast', 'id' ),
			'description'           => __( 'Background and photos', 'id' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-controls-volumeon',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'				=> $rewrite,
			'capability_type'       => 'page',
		);
		register_post_type( 'podcast', $args );
	}

	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	public function custom_sidebars() {
		$args = array(
			'id'            => 'blog_sidebar',
			'name'          => __( 'Blog Sidebar', 'bd' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		);
		register_sidebar( $args );
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['primary_menu']  = new Timber\Menu('Primary Menu');
		$context['footer_menu']  = new Timber\Menu('Footer Menu');
		$context['legal_links']  = new Timber\Menu('Legal Links');
		$context['social_media_links']  = new Timber\Menu('Social Media Profiles');
		// $context['foo']   = 'bar';
		// $context['stuff'] = 'I am a value set in your functions.php file';
		// $context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = new Timber\Menu();
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		// add_theme_support(
		// 	'post-formats',
		// 	array(
		// 		'aside',
		// 		'image',
		// 		'video',
		// 		'quote',
		// 		'link',
		// 		'gallery',
		// 		'audio',
		// 	)
		// );

		add_theme_support( 'menus' );
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new StarterSite();

