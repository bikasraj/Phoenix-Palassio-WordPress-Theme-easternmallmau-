<?php
/**
 * Phoenix Palassio Theme Functions
 * PHP 5.6+ compatible
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'PHOENIX_PALASSIO_VERSION', '1.0.0' );
define( 'PHOENIX_PALASSIO_DIR', get_template_directory() );
define( 'PHOENIX_PALASSIO_URI', get_template_directory_uri() );

/* Load admin setup wizard */
if ( is_admin() ) {
    require_once PHOENIX_PALASSIO_DIR . '/admin/setup-wizard.php';
}

/* ============================================
   THEME SETUP
============================================ */
function phoenix_palassio_setup() {
    load_theme_textdomain( 'phoenix-palassio', get_template_directory() . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );

    register_nav_menus( array(
        'primary'      => __( 'Primary Menu', 'phoenix-palassio' ),
        'footer'       => __( 'Footer Menu', 'phoenix-palassio' ),
        'who-we-are'   => __( 'Who We Are Menu', 'phoenix-palassio' ),
        'get-involved' => __( 'Get Involved Menu', 'phoenix-palassio' ),
        'latest'       => __( 'Latest Menu', 'phoenix-palassio' ),
    ) );

    add_image_size( 'hero-banner',      1920, 9999, false );
    add_image_size( 'brand-card',        300, 200,  true );
    add_image_size( 'restaurant-card',   400, 250,  true );
    add_image_size( 'blog-thumb',        600, 400,  true );
    add_image_size( 'event-card',        500, 350,  true );
}
add_action( 'after_setup_theme', 'phoenix_palassio_setup' );

/* ============================================
   ENQUEUE SCRIPTS & STYLES
============================================ */
function phoenix_palassio_scripts() {
    wp_enqueue_style( 'phoenix-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap',
        array(), null
    );
    wp_enqueue_style( 'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(), '6.4.0'
    );
    wp_enqueue_style( 'phoenix-palassio-style', get_stylesheet_uri(), array(), PHOENIX_PALASSIO_VERSION );
    wp_enqueue_style( 'phoenix-palassio-extra', PHOENIX_PALASSIO_URI . '/css/extra.css', array( 'phoenix-palassio-style' ), PHOENIX_PALASSIO_VERSION );
    wp_enqueue_script( 'phoenix-palassio-main', PHOENIX_PALASSIO_URI . '/js/main.js', array( 'jquery' ), PHOENIX_PALASSIO_VERSION, true );
    wp_localize_script( 'phoenix-palassio-main', 'phoenixAjax', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'phoenix_nonce' ),
        'siteUrl' => get_site_url(),
    ) );
}
add_action( 'wp_enqueue_scripts', 'phoenix_palassio_scripts' );

/* ============================================
   CUSTOM POST TYPES
============================================ */
function phoenix_palassio_register_post_types() {

    register_post_type( 'brand', array(
        'labels'      => array(
            'name'          => __( 'Brands', 'phoenix-palassio' ),
            'singular_name' => __( 'Brand', 'phoenix-palassio' ),
            'add_new'       => __( 'Add New Brand', 'phoenix-palassio' ),
            'all_items'     => __( 'All Brands', 'phoenix-palassio' ),
        ),
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => array( 'slug' => 'brands' ),
        'menu_icon'   => 'dashicons-store',
        'supports'    => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'show_in_rest'=> true,
    ) );

    register_post_type( 'restaurant', array(
        'labels'      => array(
            'name'          => __( 'Restaurants', 'phoenix-palassio' ),
            'singular_name' => __( 'Restaurant', 'phoenix-palassio' ),
            'all_items'     => __( 'All Restaurants', 'phoenix-palassio' ),
        ),
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => array( 'slug' => 'dine' ),
        'menu_icon'   => 'dashicons-food',
        'supports'    => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'show_in_rest'=> true,
    ) );

    register_post_type( 'entertainment', array(
        'labels'      => array(
            'name'          => __( 'Entertainment', 'phoenix-palassio' ),
            'singular_name' => __( 'Entertainment', 'phoenix-palassio' ),
            'all_items'     => __( 'All Entertainment', 'phoenix-palassio' ),
        ),
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => array( 'slug' => 'entertainment' ),
        'menu_icon'   => 'dashicons-tickets-alt',
        'supports'    => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'show_in_rest'=> true,
    ) );

    register_post_type( 'event', array(
        'labels'      => array(
            'name'          => __( 'Events', 'phoenix-palassio' ),
            'singular_name' => __( 'Event', 'phoenix-palassio' ),
            'all_items'     => __( 'All Events', 'phoenix-palassio' ),
        ),
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => array( 'slug' => 'events' ),
        'menu_icon'   => 'dashicons-calendar-alt',
        'supports'    => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'show_in_rest'=> true,
    ) );

    register_post_type( 'offer', array(
        'labels'      => array(
            'name'          => __( 'Offers & Packages', 'phoenix-palassio' ),
            'singular_name' => __( 'Offer', 'phoenix-palassio' ),
            'all_items'     => __( 'All Offers', 'phoenix-palassio' ),
        ),
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => array( 'slug' => 'offers-and-packages' ),
        'menu_icon'   => 'dashicons-tag',
        'supports'    => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'show_in_rest'=> true,
    ) );

    register_post_type( 'slide', array(
        'labels'      => array(
            'name'          => __( 'Hero Slides', 'phoenix-palassio' ),
            'singular_name' => __( 'Slide', 'phoenix-palassio' ),
            'all_items'     => __( 'All Slides', 'phoenix-palassio' ),
        ),
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-images-alt',
        'supports'    => array( 'title', 'thumbnail', 'custom-fields', 'page-attributes' ),
        'show_in_rest'=> true,
    ) );
}
add_action( 'init', 'phoenix_palassio_register_post_types' );

/* ============================================
   CUSTOM TAXONOMIES
============================================ */
function phoenix_palassio_register_taxonomies() {
    register_taxonomy( 'brand_category', 'brand', array(
        'labels'       => array(
            'name'          => __( 'Brand Categories', 'phoenix-palassio' ),
            'singular_name' => __( 'Brand Category', 'phoenix-palassio' ),
        ),
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => array( 'slug' => 'brand-category' ),
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'phoenix_palassio_register_taxonomies' );

/* ============================================
   WIDGETS
============================================ */
function phoenix_palassio_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'phoenix-palassio' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'phoenix_palassio_widgets_init' );

/* ============================================
   CUSTOMIZER OPTIONS
============================================ */
function phoenix_palassio_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'phoenix_mall_info', array(
        'title'    => __( 'Mall Information', 'phoenix-palassio' ),
        'priority' => 30,
    ) );

    $fields = array(
        'mall_timings'   => 'Mall Timings',
        'mall_phone'     => 'Phone Number',
        'mall_location'  => 'Location Name',
        'mall_map_embed' => 'Map Embed URL',
        'mall_address'   => 'Registered Office Address',
        'mall_address2'  => 'Mall Address',
        'facebook_url'   => 'Facebook URL',
        'twitter_url'    => 'Twitter URL',
        'instagram_url'  => 'Instagram URL',
        'youtube_url'    => 'YouTube URL',
        'ola_link'       => 'OLA Link',
        'uber_link'      => 'UBER Link',
    );

    foreach ( $fields as $key => $label ) {
        $wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( $key, array( 'label' => $label, 'section' => 'phoenix_mall_info', 'type' => 'text' ) );
    }
}
add_action( 'customize_register', 'phoenix_palassio_customize_register' );

/* ============================================
   HELPER FUNCTIONS
============================================ */
function phoenix_get_option( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
}

function phoenix_breadcrumb() {
    if ( is_front_page() ) {
        return;
    }
    $output = '<nav class="breadcrumb"><div class="container">';
    $output .= '<a href="' . esc_url( home_url() ) . '">' . __( 'Home', 'phoenix-palassio' ) . '</a>';
    if ( is_single() || is_page() ) {
        $output .= ' &rsaquo; <span>' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_post_type_archive() ) {
        $output .= ' &rsaquo; <span>' . esc_html( post_type_archive_title( '', false ) ) . '</span>';
    }
    $output .= '</div></nav>';
    echo $output;
}

function phoenix_veg_nonveg_badges( $veg, $nonveg ) {
    $output = '<div class="veg-nonveg-badges">';
    if ( $veg ) {
        $output .= '<span class="badge-veg"><span class="dot-veg"></span> VEG</span>';
    }
    if ( $nonveg ) {
        $output .= '<span class="badge-nonveg"><span class="dot-nonveg"></span> NON VEG</span>';
    }
    $output .= '</div>';
    return $output;
}

/* ============================================
   AJAX: Newsletter
============================================ */
function phoenix_newsletter_subscribe() {
    check_ajax_referer( 'phoenix_nonce', 'nonce' );
    $email = '';
    if ( isset( $_POST['email'] ) ) {
        $email = sanitize_email( $_POST['email'] );
    }
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => __( 'Invalid email address.', 'phoenix-palassio' ) ) );
        return;
    }
    $subscribers = get_option( 'phoenix_subscribers', array() );
    if ( ! in_array( $email, $subscribers ) ) {
        $subscribers[] = $email;
        update_option( 'phoenix_subscribers', $subscribers );
    }
    wp_send_json_success( array( 'message' => __( 'Thank you for subscribing!', 'phoenix-palassio' ) ) );
}
add_action( 'wp_ajax_phoenix_newsletter', 'phoenix_newsletter_subscribe' );
add_action( 'wp_ajax_nopriv_phoenix_newsletter', 'phoenix_newsletter_subscribe' );

/* ============================================
   EXCERPT
============================================ */
function phoenix_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'phoenix_excerpt_length' );

/* ============================================
   META BOXES
============================================ */
function phoenix_add_meta_boxes() {
    add_meta_box( 'brand_details',         __( 'Brand Details', 'phoenix-palassio' ),         'phoenix_brand_meta_box',         'brand',         'normal', 'high' );
    add_meta_box( 'restaurant_details',    __( 'Restaurant Details', 'phoenix-palassio' ),    'phoenix_restaurant_meta_box',    'restaurant',    'normal', 'high' );
    add_meta_box( 'event_details',         __( 'Event Details', 'phoenix-palassio' ),         'phoenix_event_meta_box',         'event',         'normal', 'high' );
    add_meta_box( 'offer_details',         __( 'Offer Details', 'phoenix-palassio' ),         'phoenix_offer_meta_box',         'offer',         'normal', 'high' );
    add_meta_box( 'entertainment_details', __( 'Entertainment Details', 'phoenix-palassio' ), 'phoenix_entertainment_meta_box', 'entertainment', 'normal', 'high' );
    add_meta_box( 'slide_details',         __( 'Slide Details', 'phoenix-palassio' ),         'phoenix_slide_meta_box',         'slide',         'normal', 'high' );
}
add_action( 'add_meta_boxes', 'phoenix_add_meta_boxes' );

function phoenix_brand_meta_box( $post ) {
    wp_nonce_field( 'phoenix_brand_meta', 'phoenix_brand_nonce' );
    $phone    = get_post_meta( $post->ID, '_brand_phone', true );
    $floor    = get_post_meta( $post->ID, '_brand_floor', true );
    $category = get_post_meta( $post->ID, '_brand_category_text', true );
    echo '<p><label>' . esc_html__( 'Phone', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="brand_phone" value="' . esc_attr( $phone ) . '" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Floor', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="brand_floor" value="' . esc_attr( $floor ) . '" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Category (display text)', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="brand_category_text" value="' . esc_attr( $category ) . '" style="width:100%"></p>';
}

function phoenix_restaurant_meta_box( $post ) {
    wp_nonce_field( 'phoenix_restaurant_meta', 'phoenix_restaurant_nonce' );
    $timing = get_post_meta( $post->ID, '_restaurant_timing', true );
    $floor  = get_post_meta( $post->ID, '_restaurant_floor', true );
    $veg    = get_post_meta( $post->ID, '_restaurant_veg', true );
    $nonveg = get_post_meta( $post->ID, '_restaurant_nonveg', true );
    $type   = get_post_meta( $post->ID, '_restaurant_type_text', true );
    echo '<p><label>' . esc_html__( 'Timing', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="restaurant_timing" value="' . esc_attr( $timing ) . '" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Floor', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="restaurant_floor" value="' . esc_attr( $floor ) . '" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Type', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="restaurant_type_text" value="' . esc_attr( $type ) . '" style="width:100%"></p>';
    echo '<p><label><input type="checkbox" name="restaurant_veg" value="1" ' . checked( $veg, '1', false ) . '> ';
    echo esc_html__( 'Serves Veg', 'phoenix-palassio' ) . '</label></p>';
    echo '<p><label><input type="checkbox" name="restaurant_nonveg" value="1" ' . checked( $nonveg, '1', false ) . '> ';
    echo esc_html__( 'Serves Non-Veg', 'phoenix-palassio' ) . '</label></p>';
}

function phoenix_event_meta_box( $post ) {
    wp_nonce_field( 'phoenix_event_meta', 'phoenix_event_nonce' );
    $date     = get_post_meta( $post->ID, '_event_date', true );
    $timing   = get_post_meta( $post->ID, '_event_timing', true );
    $price    = get_post_meta( $post->ID, '_event_price', true );
    $category = get_post_meta( $post->ID, '_event_category', true );
    echo '<p><label>' . esc_html__( 'Event Date', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="event_date" value="' . esc_attr( $date ) . '" placeholder="14 Mar 2026" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Timing', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="event_timing" value="' . esc_attr( $timing ) . '" placeholder="9:00AM - 10:00PM" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Price', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="event_price" value="' . esc_attr( $price ) . '" placeholder="100" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Category', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="event_category" value="' . esc_attr( $category ) . '" placeholder="Others" style="width:100%"></p>';
}

function phoenix_offer_meta_box( $post ) {
    wp_nonce_field( 'phoenix_offer_meta', 'phoenix_offer_nonce' );
    $price    = get_post_meta( $post->ID, '_offer_price', true );
    $validity = get_post_meta( $post->ID, '_offer_validity', true );
    $type     = get_post_meta( $post->ID, '_offer_type_select', true );
    echo '<p><label>' . esc_html__( 'Price / Discount', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="offer_price" value="' . esc_attr( $price ) . '" placeholder="NOW ONLY@599" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Validity', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="offer_validity" value="' . esc_attr( $validity ) . '" placeholder="30th June 2026" style="width:100%"></p>';
    $sel_offer   = selected( $type, 'offer',   false );
    $sel_package = selected( $type, 'package', false );
    echo '<p><label>' . esc_html__( 'Type', 'phoenix-palassio' ) . '</label><br>';
    echo '<select name="offer_type_select" style="width:100%">';
    echo '<option value="offer" '   . $sel_offer   . '>Offer</option>';
    echo '<option value="package" ' . $sel_package . '>Package</option>';
    echo '</select></p>';
}

function phoenix_entertainment_meta_box( $post ) {
    wp_nonce_field( 'phoenix_entertainment_meta', 'phoenix_entertainment_nonce' );
    $timing = get_post_meta( $post->ID, '_entertainment_timing', true );
    $type   = get_post_meta( $post->ID, '_entertainment_type', true );
    echo '<p><label>' . esc_html__( 'Timing', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="entertainment_timing" value="' . esc_attr( $timing ) . '" placeholder="11:00AM - 9:30PM" style="width:100%"></p>';
    $sel_movies    = selected( $type, 'movies',    false );
    $sel_fun_games = selected( $type, 'fun_games', false );
    echo '<p><label>' . esc_html__( 'Type', 'phoenix-palassio' ) . '</label><br>';
    echo '<select name="entertainment_type" style="width:100%">';
    echo '<option value="movies" '    . $sel_movies    . '>Movies</option>';
    echo '<option value="fun_games" ' . $sel_fun_games . '>Fun &amp; Games</option>';
    echo '</select></p>';
}

function phoenix_slide_meta_box( $post ) {
    wp_nonce_field( 'phoenix_slide_meta', 'phoenix_slide_nonce' );
    $headline     = get_post_meta( $post->ID, '_slide_headline', true );
    $offer_text   = get_post_meta( $post->ID, '_slide_offer_text', true );
    $offer_period = get_post_meta( $post->ID, '_slide_offer_period', true );
    $layout       = get_post_meta( $post->ID, '_slide_layout', true );
    $link         = get_post_meta( $post->ID, '_slide_link', true );
    echo '<p><label>' . esc_html__( 'Headline', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="slide_headline" value="' . esc_attr( $headline ) . '" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Offer Text', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="slide_offer_text" value="' . esc_attr( $offer_text ) . '" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Offer Period', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="text" name="slide_offer_period" value="' . esc_attr( $offer_period ) . '" style="width:100%"></p>';
    echo '<p><label>' . esc_html__( 'Link URL', 'phoenix-palassio' ) . '</label><br>';
    echo '<input type="url" name="slide_link" value="' . esc_attr( $link ) . '" style="width:100%"></p>';
    $sel_split = selected( $layout, 'split', false );
    $sel_full  = selected( $layout, 'full',  false );
    echo '<p><label>' . esc_html__( 'Layout', 'phoenix-palassio' ) . '</label><br>';
    echo '<select name="slide_layout" style="width:100%">';
    echo '<option value="split" ' . $sel_split . '>Split (Image + Content)</option>';
    echo '<option value="full" '  . $sel_full  . '>Full Width Image</option>';
    echo '</select></p>';
}

/* ============================================
   SAVE META BOXES
============================================ */
function phoenix_save_meta_boxes( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $post_type = get_post_type( $post_id );

    /* Brand */
    if ( 'brand' === $post_type ) {
        if ( isset( $_POST['phoenix_brand_nonce'] ) && wp_verify_nonce( $_POST['phoenix_brand_nonce'], 'phoenix_brand_meta' ) ) {
            $phone = isset( $_POST['brand_phone'] ) ? sanitize_text_field( $_POST['brand_phone'] ) : '';
            $floor = isset( $_POST['brand_floor'] ) ? sanitize_text_field( $_POST['brand_floor'] ) : '';
            $cat   = isset( $_POST['brand_category_text'] ) ? sanitize_text_field( $_POST['brand_category_text'] ) : '';
            update_post_meta( $post_id, '_brand_phone',          $phone );
            update_post_meta( $post_id, '_brand_floor',          $floor );
            update_post_meta( $post_id, '_brand_category_text',  $cat );
        }
    }

    /* Restaurant */
    if ( 'restaurant' === $post_type ) {
        if ( isset( $_POST['phoenix_restaurant_nonce'] ) && wp_verify_nonce( $_POST['phoenix_restaurant_nonce'], 'phoenix_restaurant_meta' ) ) {
            $timing = isset( $_POST['restaurant_timing'] )   ? sanitize_text_field( $_POST['restaurant_timing'] )   : '';
            $floor  = isset( $_POST['restaurant_floor'] )    ? sanitize_text_field( $_POST['restaurant_floor'] )    : '';
            $rtype  = isset( $_POST['restaurant_type_text'] )? sanitize_text_field( $_POST['restaurant_type_text'] ): '';
            $veg    = isset( $_POST['restaurant_veg'] )      ? '1' : '0';
            $nonveg = isset( $_POST['restaurant_nonveg'] )   ? '1' : '0';
            update_post_meta( $post_id, '_restaurant_timing',    $timing );
            update_post_meta( $post_id, '_restaurant_floor',     $floor );
            update_post_meta( $post_id, '_restaurant_type_text', $rtype );
            update_post_meta( $post_id, '_restaurant_veg',       $veg );
            update_post_meta( $post_id, '_restaurant_nonveg',    $nonveg );
        }
    }

    /* Event */
    if ( 'event' === $post_type ) {
        if ( isset( $_POST['phoenix_event_nonce'] ) && wp_verify_nonce( $_POST['phoenix_event_nonce'], 'phoenix_event_meta' ) ) {
            $date     = isset( $_POST['event_date'] )     ? sanitize_text_field( $_POST['event_date'] )     : '';
            $timing   = isset( $_POST['event_timing'] )   ? sanitize_text_field( $_POST['event_timing'] )   : '';
            $price    = isset( $_POST['event_price'] )    ? sanitize_text_field( $_POST['event_price'] )    : '';
            $category = isset( $_POST['event_category'] ) ? sanitize_text_field( $_POST['event_category'] ) : '';
            update_post_meta( $post_id, '_event_date',     $date );
            update_post_meta( $post_id, '_event_timing',   $timing );
            update_post_meta( $post_id, '_event_price',    $price );
            update_post_meta( $post_id, '_event_category', $category );
        }
    }

    /* Offer */
    if ( 'offer' === $post_type ) {
        if ( isset( $_POST['phoenix_offer_nonce'] ) && wp_verify_nonce( $_POST['phoenix_offer_nonce'], 'phoenix_offer_meta' ) ) {
            $price    = isset( $_POST['offer_price'] )        ? sanitize_text_field( $_POST['offer_price'] )        : '';
            $validity = isset( $_POST['offer_validity'] )     ? sanitize_text_field( $_POST['offer_validity'] )     : '';
            $otype    = isset( $_POST['offer_type_select'] )  ? sanitize_text_field( $_POST['offer_type_select'] )  : 'offer';
            update_post_meta( $post_id, '_offer_price',        $price );
            update_post_meta( $post_id, '_offer_validity',     $validity );
            update_post_meta( $post_id, '_offer_type_select',  $otype );
        }
    }

    /* Entertainment */
    if ( 'entertainment' === $post_type ) {
        if ( isset( $_POST['phoenix_entertainment_nonce'] ) && wp_verify_nonce( $_POST['phoenix_entertainment_nonce'], 'phoenix_entertainment_meta' ) ) {
            $timing = isset( $_POST['entertainment_timing'] ) ? sanitize_text_field( $_POST['entertainment_timing'] ) : '';
            $etype  = isset( $_POST['entertainment_type'] )   ? sanitize_text_field( $_POST['entertainment_type'] )   : 'fun_games';
            update_post_meta( $post_id, '_entertainment_timing', $timing );
            update_post_meta( $post_id, '_entertainment_type',   $etype );
        }
    }

    /* Slide */
    if ( 'slide' === $post_type ) {
        if ( isset( $_POST['phoenix_slide_nonce'] ) && wp_verify_nonce( $_POST['phoenix_slide_nonce'], 'phoenix_slide_meta' ) ) {
            $headline = isset( $_POST['slide_headline'] )     ? sanitize_text_field( $_POST['slide_headline'] )     : '';
            $otext    = isset( $_POST['slide_offer_text'] )   ? sanitize_text_field( $_POST['slide_offer_text'] )   : '';
            $operiod  = isset( $_POST['slide_offer_period'] ) ? sanitize_text_field( $_POST['slide_offer_period'] ) : '';
            $slink    = isset( $_POST['slide_link'] )         ? esc_url_raw( $_POST['slide_link'] )                 : '';
            $slayout  = isset( $_POST['slide_layout'] )       ? sanitize_text_field( $_POST['slide_layout'] )       : 'split';
            update_post_meta( $post_id, '_slide_headline',     $headline );
            update_post_meta( $post_id, '_slide_offer_text',   $otext );
            update_post_meta( $post_id, '_slide_offer_period', $operiod );
            update_post_meta( $post_id, '_slide_link',         $slink );
            update_post_meta( $post_id, '_slide_layout',       $slayout );
        }
    }
}
add_action( 'save_post', 'phoenix_save_meta_boxes' );
