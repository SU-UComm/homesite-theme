<?php
/**
 * homesite-2017 functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package homesite-2017
 */

/** @var string name of transient used to cache events */
const HS_EVENT_TRANSIENT = 'hs17-events';

/** @var string name of the sidebar where alert widgets go */
const HS_ALERT_SIDEBAR = 'sidebar-alert';

/** @var string name of the cookie that tells us if the user has dismissed the current alert */
const HS_ALERT_COOKIE  = 'su-homesite-show-alert';


/**
 * The core Stanford plugin adds an endpoint, clear-cache, which clears all transients that volunteer
 * to be cleared. This filter adds the events transient to the list of transients to be cleared.
 *
 * @param array $transients names of transients that will be deleted
 */
add_filter( 'clear_homesite_transients', function ( $transients ) {
  $transients[] = HS_EVENT_TRANSIENT;
  return $transients;
} );


function homesite17_version() {
  if ( ! defined( 'BUILD_THEME_ASSETS_TIMESTAMP' ) && file_exists( trailingslashit( ABSPATH ) . 'build-process.php' ) ) {
    require_once( trailingslashit( ABSPATH ) . 'build-process.php' );
  }

  if ( defined( 'BUILD_THEME_ASSETS_TIMESTAMP' ) ) {
    return BUILD_THEME_ASSETS_TIMESTAMP;
  }

  return '17.1.1';
}

/**
 * @var array $homesite17_image_sizes specs for each size we want an image cropped to
 */
$homesite17_image_sizes = [
    'sm' => [
        'label'         => 'SM'
      , 'crop-to-width' => 575
      , 'ar-width'      => 1
      , 'ar-height'     => 1
      , 'force'         => FALSE
      , 'selectable'    => TRUE
    ]
  , 'xl' => [
        'label'         => 'XL'
      , 'crop-to-width' => 1499
      , 'ar-width'      => 1
      , 'ar-height'     => 1
      , 'force'         => FALSE
      , 'selectable'    => TRUE
    ]
  , 'splash' => [
        'label'         => 'Splash'
      , 'crop-to-width' => 2560
      , 'ar-width'      => 1
      , 'ar-height'     => 1
      , 'force'         => FALSE
      , 'selectable'    => FALSE
    ]
/*
  , 'splash-portrait-xs' => [
        'label'         => 'Splash Portrait XS'
      , 'crop-to-width' => 575
      , 'ar-width'      => 2
      , 'ar-height'     => 3
      , 'force'         => TRUE
      , 'selectable'    => FALSE
    ]
  , 'splash-portrait-sm' => [
        'label'         => 'Splash Portrait SM'
      , 'crop-to-width' => 768
      , 'ar-width'      => 2
      , 'ar-height'     => 3
      , 'force'         => TRUE
      , 'selectable'    => FALSE
    ]
  , 'splash-portrait-md' => [
        'label'         => 'Splash Portrait MD'
      , 'crop-to-width' => 1024
      , 'ar-width'      => 2
      , 'ar-height'     => 3
      , 'force'         => TRUE
      , 'selectable'    => FALSE
    ]
*/
];

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function homesite17_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on homesite-2017, use a find and replace
	 * to change 'homesite17' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'stanford-text-domain', get_template_directory() . '/languages' );

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

	// Register our various navs
	register_nav_menus( [
      'primary'   => esc_html__( 'Primary', 'stanford-text-domain' )
		, 'gateway'   => esc_html__( 'Gateway', 'stanford-text-domain' )
	] );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', [
      'search-form'
    , 'comment-form'
		, 'comment-list'
		, 'gallery'
		, 'caption'
	] );

	/*
	 * Specify our custom image sizes
	 */
/*
 * only need to do this once, not every time WordPress initializes
  update_option( 'thumbnail_size_w', 240 );
  update_option( 'thumbnail_size_h', 240 );
  update_option( 'thumbnail_crop', 1 );

  update_option( 'medium_size_w', 767 );
  update_option( 'medium_size_h', 767 );

  update_option( 'large_size_w', 1023 );
  update_option( 'large_size_h', 1023 );
*/

  global $homesite17_image_sizes;
if(is_array($homesite17_image_sizes)){
  foreach ( $homesite17_image_sizes as $slug => $crop ) {
    $height = ceil( ( $crop[ 'crop-to-width' ] / $crop[ 'ar-width' ] ) * $crop[ 'ar-height' ] );
    add_image_size( $slug, $crop[ 'crop-to-width' ], $height, $crop[ 'force' ] );
  }
}
}
add_action( 'after_setup_theme', 'homesite17_setup' );

/**
 * Do our init after all plugins have been initialized
 */
function homesite17_init() {
  require get_template_directory() . '/inc/template-tags.php';
	require get_template_directory() . '/inc/shortcodes.php';
	require get_template_directory() . '/inc/Preview_Page.php';

  // if there's an active alert, we need a cookie to keep track of whether or not the user has dismissed it
  if ( is_active_sidebar( HS_ALERT_SIDEBAR ) ) {
    // always set the cookie to true on the homepage; on interior pages, only set it if it isn't already set
    // NOTE: by the time is_front_page() returns true, output has already started and it's too late to set a cookie
    if ( $_SERVER[ 'REQUEST_URI' ] == '/' || ! isset( $_COOKIE[ HS_ALERT_COOKIE ] ) ) {
      setcookie( HS_ALERT_COOKIE, 'true', 0, '/' );
    }
  } elseif ( isset( $_COOKIE[ HS_ALERT_COOKIE ] ) ) {
    setcookie( HS_ALERT_COOKIE, 'false', time() - 3600, '/' );
  }

  add_filter( 'feed_link', function($feed, $link){ return 'http://news.stanford.edu/feed/'; }, 10, 2 );
  add_filter( 'feed_links_show_comments_feed', '__return_false' );
}
add_action( 'init', 'homesite17_init', 15 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function homesite17_widgets_init() {
  // register our sidebars
  register_sidebar( [
      'name'          => esc_html__( 'Alert', 'stanford-text-domain' )
    , 'id'            => HS_ALERT_SIDEBAR
    , 'description'   => esc_html__( 'Drag an alert widget here to display the alert on all pages of homesite.', 'stanford-text-domain' )
    , 'before_widget' => '<section id="%1$s" class="widget %2$s %%s" data-ga-category="Widget" data-ga-action="%2$s">' // keep the last %s so the widget can easily add class(es) to its container
    , 'after_widget'  => '</section>'
    , 'before_title'  => '' // '<h2 class="widget-title">'
    , 'after_title'   => '' // '</h2>'
  ] );

  // remove we won't use on homesite
  $unwanted_widgets = [
      'WP_Widget_Archives'
    , 'WP_Widget_Calendar'
    , 'WP_Widget_Categories'
    , 'WP_Widget_Links'
    , 'WP_Widget_Meta'
    , 'WP_Widget_Pages'
    , 'WP_Widget_Recent_Posts'
    , 'WP_Widget_Recent_Comments'
    , 'WP_Widget_RSS'
    , 'WP_Widget_Search'
    , 'WP_Widget_Tag_Cloud'
    //, 'WP_Widget_Text'
    , 'WP_Nav_Menu_Widget'
    //, 'AwesomeWeatherWidget'
  ];
  foreach ( $unwanted_widgets as $widget ) {
    unregister_widget( $widget );
  }

  // add the widgets we do want to use
  require get_template_directory() . '/inc/Widget_Alert.php';
  register_widget( 'HS_Widget_Alert' );
}
add_action( 'widgets_init', 'homesite17_widgets_init', 99 );

/**
 * Enqueue scripts and styles.
 */
function homesite17_scripts() {
	wp_enqueue_style(  'homesite17-style', get_stylesheet_uri() );
	wp_enqueue_style(  'homesite17-master-style',   get_template_directory_uri() . '/css/master.min.css',    FALSE, homesite17_version(), 'all');
	wp_enqueue_script( 'homesite17-master-scripts', get_template_directory_uri() . '/js/dist/master.min.js', [],    homesite17_version(), TRUE );
	//wp_enqueue_script( 'homesite17-master-scripts', get_template_directory_uri() . '/js/scripts.js', time(), homesite17_version(), TRUE );

	// wp_enqueue_script( 'homesite17-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
}
add_action( 'wp_enqueue_scripts', 'homesite17_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function homesite17_admin_scripts() {
	wp_enqueue_style(  'homesite17-admin-style',   get_template_directory_uri() . '/css/admin.css',        FALSE, homesite17_version(), 'all');

  $script_handle = 'homesite17-admin-js';
  $script_data   = array(
      'ajaxurl' => admin_url('admin-ajax.php')
    , 'nonce'   => wp_create_nonce($script_handle)
  );
  wp_register_script($script_handle, get_template_directory_uri() . '/js/admin.js', [], homesite17_version(), TRUE );
  wp_localize_script($script_handle, 'hs17', $script_data);
  wp_enqueue_script($script_handle);
}
add_action( 'admin_enqueue_scripts', 'homesite17_admin_scripts' );

/**
 * Determine how many revisions to keep based on post type
 *
 * @param int $num
 * @param WP_Post $post
 *
 * @return int
 */
function homesite17_revisions_to_keep( $num, $post ) {
  switch ( $post->post_type ) {
    case 'page':
    case \Stanford\Homesite\Post_Types\News::NAME:
      return 5;
      break;
  }
  return 3;
}
add_filter( 'wp_revisions_to_keep', 'homesite17_revisions_to_keep', 10, 2 );

/**
 * Override the description that the Facebook Open Graph, Google+ and Twitter Card Tags plugin
 * uses for FB, Twitter and Google. If the current post has an excerpt, use that; if not, use
 * 'Stanford University - ' plus the page title.
 * Invoked via the plugin's fb_og_desc filter.
 *
 * @param string $desc - the description the plugin wants to use - unused
 *
 * @return string the current post's excerpt, if any, or 'Stanford University - ' plus the page title
 */
function homesite17_fb_og_desc( $desc ) {
  $default_desc = <<<EODESC
Stanford University, one of the world's leading teaching and research institutions, is dedicated to finding solutions to big challenges and to preparing students for leadership in a complex world.
EODESC;
  $excerpt = in_the_loop() ? get_the_excerpt() : '';
  $description = empty( $excerpt ) ? $default_desc : $excerpt;
  return $description;
}
add_filter( 'fb_og_desc', 'homesite17_fb_og_desc' );

/**
 * homesite17_pre_header - runs right before the header is emitted.
 * Invoked via the get_header action.
 *
 * Prevent clickjacking by sending X-Frame-Options: SAMEORIGIN header. This disallowd embedding our pages in a <iframe>,
 * unless the <iframe> is being rendered from www.stanford.edu.
 *
 * For all (and only) pages, right before header.php is loaded, sort the panels by section (<header>, <main>, <footer>).
 * If there's a splash panel in <header>, add the 'splash-panel' class to <body>.
 */
function homesite17_pre_header() {
  header( 'X-Frame-Options: SAMEORIGIN' );

  if ( is_page() ) {
    hs_sort_panels_by_region();
  }
  return;
}
add_action( 'get_header', 'homesite17_pre_header' );

function homesite17_add_body_classes( $classes ) {
  $splash_panel_type = hs_get_splash_panel_type();
  if ( !empty( $splash_panel_type ) ) {
    $classes[] = $splash_panel_type;
  }
  return $classes;
}
add_filter( 'body_class', 'homesite17_add_body_classes', 5, 1 );

/***
 * Add a label for the gateway nav within the <nav> element
 * 
 * @param  string   $nav_menu The HTML content for the navigation menu.
 * @param  stdClass $args     An object containing wp_nav_menu() arguments.
 * @return string             HTML with label inserted
 */
function homesite17_add_label_to_gateway_nav( $nav_menu, $args ) {
  if ( $args->container_id == 'gateway' ) {
    $nav_menu = preg_replace( '/>\w*<ul /', '><div class="gateway-nav--label">Information for:</div><ul ', $nav_menu );
  }
  return $nav_menu;
}
add_filter( 'wp_nav_menu', 'homesite17_add_label_to_gateway_nav', 10, 2 );