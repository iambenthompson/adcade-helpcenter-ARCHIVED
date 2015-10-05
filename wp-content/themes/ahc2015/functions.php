<?php
/**
 * Adcade Help Center 2015 functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Adcade Help Center 2015
 */

if ( ! function_exists( 'ahc2015_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ahc2015_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Adcade Help Center 2015, use a find and replace
	 * to change 'ahc2015' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'ahc2015', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Help Center Menu', 'ahc2015' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ahc2015_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // ahc2015_setup
add_action( 'after_setup_theme', 'ahc2015_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ahc2015_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ahc2015_content_width', 640 );
}
add_action( 'after_setup_theme', 'ahc2015_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ahc2015_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ahc2015' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	// Header Widget Bar
	register_sidebar( array(
		'name'          => esc_html__( 'Header Widget Bar', 'ahc2015' ),
		'id'            => 'header-widget-bar',
		// 'description'   => '',
		'before_widget' => '',
		'after_widget'  => ''
		// 'before_title'  => '<h2 class="header-widget-title">',
		// 'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ahc2015_widgets_init' );

add_shortcode('wordpress-search', 'get_search_form');

add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');
add_filter('get_the_excerpt', 'shortcode_unautop');
add_filter('get_the_excerpt', 'do_shortcode');

/**
 * Get post excerpt by post ID.
 *
 * @return string
 */
function get_post_excerpt_by_id( $post_id ) {
    global $post;
    $post = get_post( $post_id );
    setup_postdata( $post );
    $the_excerpt = get_the_excerpt();
    wp_reset_postdata();
    return $the_excerpt;
}

//Ensure that Excerpt edit box is shown for all types that support it 
function show_hidden_meta_boxes($hidden, $screen) {
    if ( 'post' == $screen->base ) {
        foreach($hidden as $key=>$value) {
            if ('postexcerpt' == $value) {
                unset($hidden[$key]);
                break;
            }
        }
    }
 
    return $hidden;
}
add_filter('default_hidden_meta_boxes', 'show_hidden_meta_boxes', 10, 2);

// Makes the recommended properties selection when editing Classes display the parent of each property in the list.
// ACF Recommended Properties relationship list extension
function recommended_properties_relationship_result( $result, $object, $field, $post ) {
    //$object is the line item post being returned, its "parent" is the immediate ancestor in WP-Types

    $parent_post_id = wpcf_pr_post_get_belongs($object->ID,'adscript-api');
    
    $parent_title = empty( $parent_post_id ) ? "NO PARENT" : get_the_title( $parent_post_id );

    $result .= ' [' . $parent_title .  ']';

    return $result;

}
add_filter('acf/fields/relationship/result/name=recommended_properties', 'recommended_properties_relationship_result', 10, 4);

/* TOTALLY BROKEN WIP FOR FILTERING OUT N/A PROPERTIES IN RECOMMENDED PROPERTIES FIELD
function relationship_options_filter($args, $field, $post) {
    
    get_ancestors($post->ID, 'page');

    $args['post__in'] = array('publish');
    
    return $args;
}
add_filter('acf/fields/relationship/query/name=recommended_properties', 'relationship_options_filter', 10, 3);
*/

//Returns all properties that a Class post has access to through its ownership and ancestry
function ahc2015_all_properties ( $post_id ){   
    return ahc2015_accessible_properties( $post_id, true );
}

//Returns all properties that a Class post directly owns
function ahc2015_original_properties ( $post_id ){
    $meta_query = array(array('key' => '_wpcf_belongs_adscript-api_id', 'value' => $post_id));

    return get_posts(array(
        'post_type' => 'property',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => $meta_query
    ));
}

//Returns all properties that a Class post has access to through its ancestry and optionally ownership
function ahc2015_accessible_properties ( $post_id, $include_myself = false ){
    $ancestor_ids = get_ancestors($post_id, 'page');

    $meta_query = array(
        'relation' => 'OR'
    );
    
    foreach ($ancestor_ids as $ancestor_id) {
        $meta_query[] = array(
            'key' => '_wpcf_belongs_adscript-api_id',
            'value' => $ancestor_id 
            );
    }

    if ($include_myself){
        $meta_query[] = array(
            'key' => '_wpcf_belongs_adscript-api_id',
            'value' => $post_id 
            );
    }   

    return get_posts(array(
        'post_type' => 'property',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => $meta_query
    ));
}

//Returns all methods that a Class post has access to through its ownership and ancestry
function ahc2015_all_methods ( $post_id ){  
    return ahc2015_accessible_methods( $post_id, true );
}

//Returns all methods that a Class post directly owns
function ahc2015_original_methods ( $post_id ){
    $meta_query = array(array('key' => '_wpcf_belongs_adscript-api_id', 'value' => $post_id));

    return get_posts(array(
        'post_type' => 'method',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => $meta_query
    ));
}

//Returns all methods that a Class post has access to through its ancestry and optionally ownership
function ahc2015_accessible_methods ( $post_id, $include_myself = false ){
    $ancestor_ids = get_ancestors($post_id, 'page');

    $meta_query = array(
        'relation' => 'OR'
    );
    
    foreach ($ancestor_ids as $ancestor_id) {
        $meta_query[] = array(
            'key' => '_wpcf_belongs_adscript-api_id',
            'value' => $ancestor_id 
            );
    }

    if ($include_myself){
        $meta_query[] = array(
            'key' => '_wpcf_belongs_adscript-api_id',
            'value' => $post_id 
            );
    }   

    return get_posts(array(
        'post_type' => 'method',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => $meta_query
    ));
}

//Returns all parameters that a Method post owns, ordered by their menu_order number
function ahc2015_method_params ( $post_id ){
    $meta_query = array(array('key' => '_wpcf_belongs_method_id', 'value' => $post_id));

    return get_posts(array(
        'post_type' => 'parameter',
        'numberposts' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => $meta_query
    ));
}

//Returns all parameter keys that a Parameter post owns, ordered alphabetically by title
function ahc2015_method_param_keys ( $post_id ){
    $meta_query = array(array('key' => '_wpcf_belongs_parameter_id', 'value' => $post_id));

    return get_posts(array(
        'post_type' => 'parameter-key',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => $meta_query
    ));
}

//Returns AdScript default value, when no value has been defined, based on passed type of variable
function ahc2015_default_empty_value($type){
    // Types:
    // object = undefined
    // integer = 0
    // number = 0
    // string = ""
    // boolean = false
    // array = undefined
    // function = undefined
    // adscript = undefined
    $value = "undefined";
    switch ($type){
        case "integer" :
        case "number" :
            $value = "0";
            break;
        case "string" :
            $value = '""';
            break;
    }

    return $value;
}

//Returns an AdScript link as an HTML anchor tag with link text based on a few passed params
function ahc2015_adscript_link_html ( $post_id, $text = "", $anchor = "", $extra_classes = "" ){
    $adscript_post = get_post( $post_id );
    if (!empty($anchor)) 
        $anchor = "#" . $anchor;
    if (empty($text))
        $text = $adscript_post->post_title;
    if (!empty($extra_classes))
        $extra_classes = " " . $extra_classes;
    return '<a href="' . post_permalink($post_id) . $anchor . '" class="adscript-link' . $extra_classes . '">' . $text . '</a>';
}

/**
 * Enqueue scripts and styles.
 */
function ahc2015_scripts() {
	wp_enqueue_style( 'ahc2015-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ahc2015-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'ahc2015-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ahc2015_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
