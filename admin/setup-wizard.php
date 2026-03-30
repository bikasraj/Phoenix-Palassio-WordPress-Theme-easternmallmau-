<?php
/**
 * Phoenix Palassio - Setup Wizard + Demo Importer
 * PHP 5.6+ compatible. Single file. No external dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ============================================================
   ADMIN MENU
============================================================ */
if ( ! function_exists( 'phoenix_add_admin_pages' ) ) {
    function phoenix_add_admin_pages() {
        add_menu_page(
            'Phoenix Setup',
            '🦅 Phoenix Setup',
            'manage_options',
            'phoenix-setup',
            'phoenix_setup_wizard_page',
            'dashicons-store',
            2
        );
    }
    add_action( 'admin_menu', 'phoenix_add_admin_pages' );
}

/* ============================================================
   ADMIN NOTICE
============================================================ */
if ( ! function_exists( 'phoenix_admin_setup_notice' ) ) {
    function phoenix_admin_setup_notice() {
        if ( get_option( 'phoenix_demo_imported' ) ) {
            return;
        }
        $screen = get_current_screen();
        if ( $screen && strpos( $screen->id, 'phoenix-setup' ) !== false ) {
            return;
        }
        echo '<div class="notice notice-info" style="border-left:4px solid #C9A84C;padding:14px 20px;display:flex;align-items:center;gap:20px;background:#fffdf5;">';
        echo '<span style="font-size:2rem;">🦅</span>';
        echo '<div><strong style="color:#8a6914;font-size:1rem;">Phoenix Palassio Theme Activated!</strong>';
        echo '<p style="margin:4px 0 0;">Run the one-click demo setup to import all pages, brands, restaurants, events and more.</p></div>';
        echo '<a href="' . esc_url( admin_url( 'admin.php?page=phoenix-setup' ) ) . '" style="background:#C9A84C;color:#fff;padding:10px 22px;border-radius:4px;text-decoration:none;font-weight:700;white-space:nowrap;margin-left:auto;">🚀 Setup Now</a>';
        echo '</div>';
    }
    add_action( 'admin_notices', 'phoenix_admin_setup_notice' );
}

/* ============================================================
   AJAX: IMPORT STEP
============================================================ */
if ( ! function_exists( 'phoenix_ajax_import_step' ) ) {
    function phoenix_ajax_import_step() {
        while ( ob_get_level() ) {
            ob_end_clean();
        }
        check_ajax_referer( 'phoenix_import_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => 'Permission denied' ) );
            return;
        }
        $step = '';
        if ( isset( $_POST['step'] ) ) {
            $step = sanitize_text_field( $_POST['step'] );
        }
        if ( ! $step ) {
            wp_send_json_error( array( 'message' => 'No step provided' ) );
            return;
        }
        @ini_set( 'memory_limit', '256M' );
        @set_time_limit( 120 );
        $result = phoenix_run_import_step( $step );
        while ( ob_get_level() ) {
            ob_end_clean();
        }
        wp_send_json( $result );
    }
    add_action( 'wp_ajax_phoenix_import_step', 'phoenix_ajax_import_step' );
}

/* ============================================================
   AJAX: RESET DEMO
============================================================ */
if ( ! function_exists( 'phoenix_ajax_reset_demo' ) ) {
    function phoenix_ajax_reset_demo() {
        while ( ob_get_level() ) {
            ob_end_clean();
        }
        check_ajax_referer( 'phoenix_import_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => 'Permission denied' ) );
            return;
        }
        $result = phoenix_reset_demo_data();
        while ( ob_get_level() ) {
            ob_end_clean();
        }
        wp_send_json_success( $result );
    }
    add_action( 'wp_ajax_phoenix_reset_demo', 'phoenix_ajax_reset_demo' );
}

/* ============================================================
   STEP ROUTER
============================================================ */
if ( ! function_exists( 'phoenix_run_import_step' ) ) {
    function phoenix_run_import_step( $step ) {
        if ( 'customizer' === $step )    { return phoenix_import_customizer(); }
        if ( 'pages' === $step )         { return phoenix_import_pages(); }
        if ( 'slides' === $step )        { return phoenix_import_slides(); }
        if ( 'brands' === $step )        { return phoenix_import_brands(); }
        if ( 'restaurants' === $step )   { return phoenix_import_restaurants(); }
        if ( 'entertainment' === $step ) { return phoenix_import_entertainment(); }
        if ( 'events' === $step )        { return phoenix_import_events(); }
        if ( 'offers' === $step )        { return phoenix_import_offers(); }
        if ( 'posts' === $step )         { return phoenix_import_posts(); }
        if ( 'menus' === $step )         { return phoenix_import_menus(); }
        if ( 'finalize' === $step )      { return phoenix_import_finalize(); }
        return array( 'success' => false, 'message' => 'Unknown step: ' . $step );
    }
}

/* ============================================================
   IMAGE HELPER
============================================================ */
if ( ! function_exists( 'phoenix_make_image' ) ) {
    function phoenix_make_image( $label, $hex_color, $hex_bg, $w, $h ) {
        if ( ! function_exists( 'imagecreatetruecolor' ) ) {
            return 0;
        }
        $img = imagecreatetruecolor( $w, $h );
        $bh  = ltrim( $hex_bg, '#' );
        $br  = hexdec( substr( $bh, 0, 2 ) );
        $bgv = hexdec( substr( $bh, 2, 2 ) );
        $bb  = hexdec( substr( $bh, 4, 2 ) );
        $bg  = imagecolorallocate( $img, $br, $bgv, $bb );
        imagefill( $img, 0, 0, $bg );
        for ( $y = 0; $y < $h; $y++ ) {
            $t  = $y / $h;
            $rr = (int) ( $br  * ( 1 - $t * 0.35 ) );
            $rg = (int) ( $bgv * ( 1 - $t * 0.35 ) );
            $rb = (int) ( $bb  * ( 1 - $t * 0.35 ) );
            $rc = imagecolorallocate( $img, max( 0, $rr ), max( 0, $rg ), max( 0, $rb ) );
            imageline( $img, 0, $y, $w, $y, $rc );
        }
        $ch  = ltrim( $hex_color, '#' );
        $cr  = hexdec( substr( $ch, 0, 2 ) );
        $cg  = hexdec( substr( $ch, 2, 2 ) );
        $cb  = hexdec( substr( $ch, 4, 2 ) );
        $ac  = imagecolorallocate( $img, $cr, $cg, $cb );
        $acd = imagecolorallocatealpha( $img, $cr, $cg, $cb, 80 );
        imagesetthickness( $img, 3 );
        imageline( $img, 0, $h, (int) ( $w * 0.7 ), 0, $acd );
        imageline( $img, (int) ( $w * 0.3 ), $h, $w, 0, $acd );
        imagefilledrectangle( $img, 0, $h - 6, $w, $h, $ac );
        $cx = $w / 2;
        $cy = $h * 0.38;
        $s  = min( $w, $h ) * 0.11;
        imagefilledpolygon( $img, array( (int) $cx, (int) $cy, (int) ( $cx - $s * 2 ), (int) ( $cy - $s * 0.7 ), (int) ( $cx - $s * 1.4 ), (int) ( $cy + $s * 0.5 ) ), 3, $ac );
        imagefilledpolygon( $img, array( (int) $cx, (int) $cy, (int) ( $cx + $s * 2 ), (int) ( $cy - $s * 0.7 ), (int) ( $cx + $s * 1.4 ), (int) ( $cy + $s * 0.5 ) ), 3, $ac );
        imagefilledellipse( $img, (int) $cx, (int) $cy, (int) ( $s * 1.1 ), (int) ( $s * 1.3 ), $ac );
        imagefilledellipse( $img, (int) $cx, (int) ( $cy - $s * 0.85 ), (int) ( $s * 0.65 ), (int) ( $s * 0.65 ), $ac );
        $fn    = 5;
        $fcw   = imagefontwidth( $fn );
        $fch   = imagefontheight( $fn );
        $text  = strtoupper( $label );
        $maxc  = (int) ( ( $w - 80 ) / $fcw );
        $words = explode( ' ', $text );
        $lines = array();
        $cur   = '';
        foreach ( $words as $wd ) {
            if ( strlen( $cur . ' ' . $wd ) <= $maxc ) {
                $cur = trim( $cur . ' ' . $wd );
            } else {
                if ( $cur ) {
                    $lines[] = $cur;
                }
                $cur = $wd;
            }
        }
        if ( $cur ) {
            $lines[] = $cur;
        }
        $lines = array_slice( $lines, 0, 3 );
        $sy    = (int) ( $h * 0.68 );
        foreach ( $lines as $li => $ln ) {
            $lw = strlen( $ln ) * $fcw;
            imagestring( $img, $fn, (int) ( ( $w - $lw ) / 2 ), $sy + $li * ( $fch + 5 ), $ln, $ac );
        }
        $wm = imagecolorallocatealpha( $img, $cr, $cg, $cb, 90 );
        imagestring( $img, 2, $w - 132, $h - 20, 'PHOENIX PALASSIO', $wm );
        $upload = wp_upload_dir();
        if ( ! empty( $upload['error'] ) ) {
            imagedestroy( $img );
            return 0;
        }
        $fname = sanitize_file_name( strtolower( str_replace( ' ', '-', $label ) ) ) . '-' . wp_rand( 1000, 9999 ) . '.jpg';
        $fpath = trailingslashit( $upload['path'] ) . $fname;
        $furl  = trailingslashit( $upload['url'] )  . $fname;
        imagejpeg( $img, $fpath, 85 );
        imagedestroy( $img );
        if ( ! file_exists( $fpath ) ) {
            return 0;
        }
        $aid = wp_insert_attachment( array(
            'guid'           => $furl,
            'post_mime_type' => 'image/jpeg',
            'post_title'     => sanitize_text_field( $label ),
            'post_status'    => 'inherit',
        ), $fpath );
        if ( is_wp_error( $aid ) ) {
            return 0;
        }
        if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
        }
        wp_update_attachment_metadata( $aid, wp_generate_attachment_metadata( $aid, $fpath ) );
        return $aid;
    }
}

/* ============================================================
   STEP 1 — CUSTOMIZER
============================================================ */
if ( ! function_exists( 'phoenix_import_customizer' ) ) {
    function phoenix_import_customizer() {
        $s = array(
            'mall_timings'   => 'Every day - 11:00AM - 10:00PM',
            'mall_phone'     => '05226667700',
            'mall_location'  => 'Lucknow, Phoenix Palassio',
            'mall_address'   => 'C/o Market City Resources Pvt Ltd, Ground Floor RR Hosiery Building, Shree Laxmi Woollen Mills Estate, Mahalaxmi, Mumbai 400011.',
            'mall_address2'  => 'Destiny Retail Mall Developers Private Limited, Amar Shaheed Path Sector 7, Gomti Nagar Extension, Lucknow, Uttar Pradesh-226010',
            'facebook_url'   => 'https://www.facebook.com/PhoenixPalassio',
            'twitter_url'    => 'https://twitter.com/PhoenixPalassio',
            'instagram_url'  => 'https://www.instagram.com/phoenixpalassio',
            'youtube_url'    => 'https://www.youtube.com/phoenixpalassio',
            'ola_link'       => 'https://ola.onelink.me/2353289485',
            'uber_link'      => 'https://m.uber.com/ul/?action=setPickup&pickup=my_location',
            'mall_map_embed' => 'https://maps.google.com/maps?q=Phoenix+Palassio+Lucknow&output=embed',
        );
        foreach ( $s as $k => $v ) {
            set_theme_mod( $k, $v );
        }
        return array( 'success' => true, 'message' => 'Mall settings saved (' . count( $s ) . ' options)' );
    }
}

/* ============================================================
   STEP 2 — PAGES
============================================================ */
if ( ! function_exists( 'phoenix_import_pages' ) ) {
    function phoenix_import_pages() {
        $pages = array(
            array( 'title' => 'Home',                'slug' => 'home',                'tpl' => '',                                    'front' => true ),
            array( 'title' => 'Brands',              'slug' => 'brands',              'tpl' => 'page-templates/page-brands.php'              ),
            array( 'title' => 'Dine',                'slug' => 'dine',                'tpl' => 'page-templates/page-dine.php'                ),
            array( 'title' => 'Entertainment',       'slug' => 'entertainment',       'tpl' => 'page-templates/page-entertainment.php'       ),
            array( 'title' => 'Fun and Games',       'slug' => 'fun-games',           'tpl' => 'page-templates/page-fun-games.php'           ),
            array( 'title' => 'Offers and Packages', 'slug' => 'offers-and-packages', 'tpl' => 'page-templates/page-offers.php'              ),
            array( 'title' => 'Events',              'slug' => 'events',              'tpl' => 'page-templates/page-events.php'              ),
            array( 'title' => 'Concierge Services',  'slug' => 'concierge-services',  'tpl' => 'page-templates/page-concierge.php'           ),
            array( 'title' => 'Gift Card',           'slug' => 'gift-card',           'tpl' => 'page-templates/page-gift-card.php'           ),
            array( 'title' => 'Blog',                'slug' => 'blog',                'tpl' => '',                                    'blog' => true  ),
        );
        $created  = 0;
        $skipped  = 0;
        $front_id = 0;
        $blog_id  = 0;
        foreach ( $pages as $p ) {
            $ex = get_page_by_path( $p['slug'] );
            if ( $ex ) {
                if ( $p['tpl'] ) {
                    update_post_meta( $ex->ID, '_wp_page_template', $p['tpl'] );
                }
                $skipped++;
                if ( isset( $p['front'] ) ) { $front_id = $ex->ID; }
                if ( isset( $p['blog'] ) )  { $blog_id  = $ex->ID; }
                continue;
            }
            $id = wp_insert_post( array(
                'post_title'   => $p['title'],
                'post_name'    => $p['slug'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ) );
            if ( is_wp_error( $id ) ) {
                continue;
            }
            if ( $p['tpl'] ) {
                update_post_meta( $id, '_wp_page_template', $p['tpl'] );
            }
            if ( isset( $p['front'] ) ) { $front_id = $id; }
            if ( isset( $p['blog'] ) )  { $blog_id  = $id; }
            $created++;
        }
        if ( $front_id ) {
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $front_id );
        }
        if ( $blog_id ) {
            update_option( 'page_for_posts', $blog_id );
        }
        flush_rewrite_rules();
        return array( 'success' => true, 'message' => 'Pages: ' . $created . ' created, ' . $skipped . ' already existed' );
    }
}

/* ============================================================
   STEP 3 — SLIDES
============================================================ */
if ( ! function_exists( 'phoenix_import_slides' ) ) {
    function phoenix_import_slides() {
        $slides = array(
            array( 'title' => 'Smart Watch Offer', 'headline' => 'SHOP WORTH Rs.25,000 & GET AN ASSURED SMART WATCH', 'offer_text' => 'Shop Worth Rs.25,000 & Get an Assured Smart Watch', 'period' => '02 MAR - 31 MAR 2026', 'color' => '#C9A84C', 'bg' => '#1a1a1a', 'order' => 1 ),
            array( 'title' => 'Fashion Headline',  'headline' => "SHE'S ALWAYS THE HEADLINE",                         'offer_text' => 'New Collection Now Available',                   'period' => 'Limited Time Offer',    'color' => '#E8392A', 'bg' => '#2c1810', 'order' => 2 ),
            array( 'title' => 'Sindh Fashions',    'headline' => 'SINDH FASHIONS',                                    'offer_text' => 'Exclusive Designer Collection',                  'period' => 'Visit Us Today',         'color' => '#4a90d9', 'bg' => '#0d1b2a', 'order' => 3 ),
        );
        $count = 0;
        foreach ( $slides as $s ) {
            $ex = get_posts( array( 'post_type' => 'slide', 'post_status' => 'any', 'numberposts' => 1, 'title' => $s['title'] ) );
            if ( $ex ) {
                continue;
            }
            $id = wp_insert_post( array( 'post_title' => $s['title'], 'post_status' => 'publish', 'post_type' => 'slide', 'menu_order' => $s['order'] ) );
            if ( is_wp_error( $id ) ) {
                continue;
            }
            update_post_meta( $id, '_slide_headline',     $s['headline'] );
            update_post_meta( $id, '_slide_offer_text',   $s['offer_text'] );
            update_post_meta( $id, '_slide_offer_period', $s['period'] );
            update_post_meta( $id, '_slide_layout',       'split' );
            $img = phoenix_make_image( $s['title'], $s['color'], $s['bg'], 1200, 600 );
            if ( $img ) {
                set_post_thumbnail( $id, $img );
            }
            $count++;
        }
        return array( 'success' => true, 'message' => 'Hero Slides: ' . $count . ' imported' );
    }
}

/* ============================================================
   STEP 4 — BRANDS
============================================================ */
if ( ! function_exists( 'phoenix_import_brands' ) ) {
    function phoenix_import_brands() {
        $brands = array(
            array( 'title' => 'Lifestyle',          'cat' => "Women's Fashion", 'floor' => 'Ground Floor', 'color' => '#E8392A', 'bg' => '#fff0f0' ),
            array( 'title' => 'Forever 21',         'cat' => "Women's Fashion", 'floor' => 'Second Floor', 'color' => '#000000', 'bg' => '#f5f5f5' ),
            array( 'title' => 'Shoppers Stop',      'cat' => "Women's Fashion", 'floor' => 'Ground Floor', 'color' => '#CC0000', 'bg' => '#fff0f0' ),
            array( 'title' => 'AND',                'cat' => "Women's Fashion", 'floor' => 'First Floor',  'color' => '#2C3E50', 'bg' => '#f0f4f8' ),
            array( 'title' => 'BIBA',               'cat' => "Women's Fashion", 'floor' => 'First Floor',  'color' => '#C0392B', 'bg' => '#fdf2f2' ),
            array( 'title' => 'W for Woman',        'cat' => "Women's Fashion", 'floor' => 'Second Floor', 'color' => '#922B21', 'bg' => '#fdf2f2' ),
            array( 'title' => 'Ada',                'cat' => "Women's Fashion", 'floor' => 'First Floor',  'color' => '#7D3C98', 'bg' => '#f5eef8' ),
            array( 'title' => 'Allen Solly Women',  'cat' => "Women's Fashion", 'floor' => 'First Floor',  'color' => '#1A5276', 'bg' => '#eaf2fb' ),
            array( 'title' => 'Sindh Fashions',     'cat' => "Women's Fashion", 'floor' => 'Second Floor', 'color' => '#C9A84C', 'bg' => '#0d1b2a' ),
            array( 'title' => 'Allen Solly',        'cat' => "Men's Fashion",   'floor' => 'First Floor',  'color' => '#1A5276', 'bg' => '#eaf2fb' ),
            array( 'title' => 'American Eagle',     'cat' => "Men's Fashion",   'floor' => 'Second Floor', 'color' => '#1F3A5F', 'bg' => '#eaf0fb' ),
            array( 'title' => 'Jack & Jones',       'cat' => "Men's Fashion",   'floor' => 'First Floor',  'color' => '#154360', 'bg' => '#eaf2fb' ),
            array( 'title' => 'Armani Exchange',    'cat' => "Men's Fashion",   'floor' => 'Second Floor', 'color' => '#1C2833', 'bg' => '#eaecee' ),
            array( 'title' => 'Adidas',             'cat' => 'Sports & Fitness','floor' => 'Ground Floor', 'color' => '#000000', 'bg' => '#f5f5f5' ),
            array( 'title' => 'Allen Solly Junior', 'cat' => "Kid's Fashion",   'floor' => 'First Floor',  'color' => '#17A589', 'bg' => '#e8f8f5' ),
            array( 'title' => 'Angle and Rocket',   'cat' => "Kid's Fashion",   'floor' => 'Second Floor', 'color' => '#E74C3C', 'bg' => '#fdf2f2' ),
            array( 'title' => 'ALDO',               'cat' => 'Bags & Luggage',  'floor' => 'First Floor',  'color' => '#2C2C2C', 'bg' => '#f8f8f8' ),
            array( 'title' => 'Aldo Accessories',   'cat' => 'Bags & Luggage',  'floor' => 'First Floor',  'color' => '#333333', 'bg' => '#f8f8f8' ),
            array( 'title' => 'American Tourister', 'cat' => 'Bags & Luggage',  'floor' => 'Ground Floor', 'color' => '#1F618D', 'bg' => '#eaf2fb' ),
            array( 'title' => 'Da Milano',          'cat' => 'Bags & Luggage',  'floor' => 'First Floor',  'color' => '#6E2C00', 'bg' => '#fdf0e6' ),
            array( 'title' => 'HiDesign',           'cat' => 'Bags & Luggage',  'floor' => 'Ground Floor', 'color' => '#784212', 'bg' => '#fdf5e6' ),
            array( 'title' => 'Clarks',             'cat' => 'Foot Fashion',    'floor' => 'Ground Floor', 'color' => '#2E4057', 'bg' => '#eaeff5' ),
            array( 'title' => 'Hush Puppies',       'cat' => 'Foot Fashion',    'floor' => 'First Floor',  'color' => '#C0392B', 'bg' => '#fdf2f2' ),
            array( 'title' => 'ABC Chashmewale',    'cat' => 'Eyewear',         'floor' => 'Ground Floor', 'color' => '#117A65', 'bg' => '#e8f8f5' ),
            array( 'title' => '9D Virtual Reality', 'cat' => 'Games & FEC',     'floor' => 'Third Floor',  'color' => '#6C3483', 'bg' => '#f4ecf7' ),
        );
        $all_cats = array_unique( array_column( $brands, 'cat' ) );
        $cat_ids  = array();
        foreach ( $all_cats as $cat ) {
            $t = term_exists( $cat, 'brand_category' );
            if ( ! $t ) {
                $t = wp_insert_term( $cat, 'brand_category' );
            }
            if ( ! is_wp_error( $t ) ) {
                $cat_ids[ $cat ] = is_array( $t ) ? (int) $t['term_id'] : (int) $t;
            }
        }
        $count = 0;
        foreach ( $brands as $b ) {
            $ex = get_posts( array( 'post_type' => 'brand', 'post_status' => 'any', 'numberposts' => 1, 'title' => $b['title'] ) );
            if ( $ex ) {
                continue;
            }
            $id = wp_insert_post( array( 'post_title' => $b['title'], 'post_status' => 'publish', 'post_type' => 'brand', 'post_content' => '' ) );
            if ( is_wp_error( $id ) ) {
                continue;
            }
            update_post_meta( $id, '_brand_floor',         $b['floor'] );
            update_post_meta( $id, '_brand_category_text', $b['cat'] );
            update_post_meta( $id, '_brand_phone',         '' );
            if ( isset( $cat_ids[ $b['cat'] ] ) ) {
                wp_set_post_terms( $id, array( $cat_ids[ $b['cat'] ] ), 'brand_category' );
            }
            $img = phoenix_make_image( $b['title'], $b['color'], $b['bg'], 400, 280 );
            if ( $img ) {
                set_post_thumbnail( $id, $img );
            }
            $count++;
        }
        return array( 'success' => true, 'message' => 'Brands: ' . $count . ' imported' );
    }
}

/* ============================================================
   STEP 5 — RESTAURANTS
============================================================ */
if ( ! function_exists( 'phoenix_import_restaurants' ) ) {
    function phoenix_import_restaurants() {
        $items = array(
            array( 'title' => 'Ishaara',          'type' => 'Restaurant', 'floor' => 'Second Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#1a3a5c', 'bg' => '#e8f0fa' ),
            array( 'title' => 'Dobaraa',          'type' => 'Restaurant', 'floor' => 'Second Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#4a1942', 'bg' => '#f4e8f4' ),
            array( 'title' => 'EIGHT',            'type' => 'Restaurant', 'floor' => 'Second Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#1a2a1a', 'bg' => '#e8f4e8' ),
            array( 'title' => 'Punjab Grill',     'type' => 'Restaurant', 'floor' => 'Second Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#5a2d00', 'bg' => '#f9f0e6' ),
            array( 'title' => 'KFC',              'type' => 'Restaurant', 'floor' => 'Third Floor',  'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#b11116', 'bg' => '#fef0f0' ),
            array( 'title' => 'Pizza Hut',        'type' => 'Restaurant', 'floor' => 'Second Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#a01010', 'bg' => '#fef0f0' ),
            array( 'title' => "Jamie's Pizzeria", 'type' => 'Restaurant', 'floor' => 'Second Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#2a6010', 'bg' => '#edf8e8' ),
            array( 'title' => 'Cinnabon',         'type' => 'Restaurant', 'floor' => 'Ground Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '0', 'color' => '#8B4513', 'bg' => '#fef5e6' ),
            array( 'title' => 'Burger King',      'type' => 'Food Court', 'floor' => 'Third Floor',  'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#d4600a', 'bg' => '#fef5e6' ),
            array( 'title' => 'House of Candy',   'type' => 'Restaurant', 'floor' => 'Third Floor',  'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '0', 'color' => '#c0392b', 'bg' => '#fdf2f2' ),
            array( 'title' => 'Keventers',        'type' => 'Food Court', 'floor' => 'Second Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '0', 'color' => '#8B6914', 'bg' => '#fef9e6' ),
            array( 'title' => 'Subway',           'type' => 'Food Court', 'floor' => 'Second Floor', 'timing' => '11:00AM - 11:00PM', 'veg' => '1', 'nonveg' => '1', 'color' => '#00703c', 'bg' => '#e8f8f0' ),
        );
        $count = 0;
        foreach ( $items as $r ) {
            $ex = get_posts( array( 'post_type' => 'restaurant', 'post_status' => 'any', 'numberposts' => 1, 'title' => $r['title'] ) );
            if ( $ex ) { continue; }
            $id = wp_insert_post( array( 'post_title' => $r['title'], 'post_status' => 'publish', 'post_type' => 'restaurant', 'post_content' => '' ) );
            if ( is_wp_error( $id ) ) { continue; }
            update_post_meta( $id, '_restaurant_timing',    $r['timing'] );
            update_post_meta( $id, '_restaurant_floor',     $r['floor'] );
            update_post_meta( $id, '_restaurant_type_text', $r['type'] );
            update_post_meta( $id, '_restaurant_veg',       $r['veg'] );
            update_post_meta( $id, '_restaurant_nonveg',    $r['nonveg'] );
            $img = phoenix_make_image( $r['title'], $r['color'], $r['bg'], 600, 400 );
            if ( $img ) { set_post_thumbnail( $id, $img ); }
            $count++;
        }
        return array( 'success' => true, 'message' => 'Restaurants: ' . $count . ' imported' );
    }
}

/* ============================================================
   STEP 6 — ENTERTAINMENT
============================================================ */
if ( ! function_exists( 'phoenix_import_entertainment' ) ) {
    function phoenix_import_entertainment() {
        $items = array(
            array( 'title' => 'Timezone',           'type' => 'fun_games', 'timing' => '11:00AM - 9:30PM',  'color' => '#c0392b', 'bg' => '#1a0505' ),
            array( 'title' => 'House of Fear',      'type' => 'fun_games', 'timing' => '11:00AM - 11:00PM', 'color' => '#6C3483', 'bg' => '#0d000f' ),
            array( 'title' => '9D Virtual Reality', 'type' => 'fun_games', 'timing' => '11:00AM - 11:00PM', 'color' => '#2980b9', 'bg' => '#051a2a' ),
        );
        $count = 0;
        foreach ( $items as $e ) {
            $ex = get_posts( array( 'post_type' => 'entertainment', 'post_status' => 'any', 'numberposts' => 1, 'title' => $e['title'] ) );
            if ( $ex ) { continue; }
            $id = wp_insert_post( array( 'post_title' => $e['title'], 'post_status' => 'publish', 'post_type' => 'entertainment', 'post_content' => '' ) );
            if ( is_wp_error( $id ) ) { continue; }
            update_post_meta( $id, '_entertainment_timing', $e['timing'] );
            update_post_meta( $id, '_entertainment_type',   $e['type'] );
            $img = phoenix_make_image( $e['title'], $e['color'], $e['bg'], 800, 500 );
            if ( $img ) { set_post_thumbnail( $id, $img ); }
            $count++;
        }
        return array( 'success' => true, 'message' => 'Entertainment: ' . $count . ' imported' );
    }
}

/* ============================================================
   STEP 7 — EVENTS
============================================================ */
if ( ! function_exists( 'phoenix_import_events' ) ) {
    function phoenix_import_events() {
        $items = array(
            array( 'title' => 'Phoenix Palassio Grand Table Tennis Tournament', 'date' => '14 Mar 2026', 'timing' => '9:00AM - 10:00PM',  'price' => '100', 'cat' => 'Sports',        'color' => '#1a3a5c', 'bg' => '#e8f0fa' ),
            array( 'title' => 'Republic Day Celebrations at Phoenix Palassio',  'date' => '26 Jan 2026', 'timing' => '10:00AM - 8:00PM',   'price' => '0',   'cat' => 'Cultural',      'color' => '#0a3a10', 'bg' => '#e8f8e8' ),
            array( 'title' => 'Lucknow Food Festival 2026',                     'date' => '5 Apr 2026',  'timing' => '11:00AM - 10:00PM',  'price' => '0',   'cat' => 'Food Culture',  'color' => '#5a2d00', 'bg' => '#f9f0e6' ),
            array( 'title' => 'Summer Fashion Showcase 2026',                   'date' => '15 Apr 2026', 'timing' => '6:00PM - 9:00PM',    'price' => '200', 'cat' => 'Fashion',       'color' => '#4a1942', 'bg' => '#f4e8f4' ),
        );
        $count = 0;
        foreach ( $items as $ev ) {
            $ex = get_posts( array( 'post_type' => 'event', 'post_status' => 'any', 'numberposts' => 1, 'title' => $ev['title'] ) );
            if ( $ex ) { continue; }
            $id = wp_insert_post( array( 'post_title' => $ev['title'], 'post_status' => 'publish', 'post_type' => 'event', 'post_content' => '' ) );
            if ( is_wp_error( $id ) ) { continue; }
            update_post_meta( $id, '_event_date',     $ev['date'] );
            update_post_meta( $id, '_event_timing',   $ev['timing'] );
            update_post_meta( $id, '_event_price',    $ev['price'] );
            update_post_meta( $id, '_event_category', $ev['cat'] );
            $img = phoenix_make_image( $ev['title'], $ev['color'], $ev['bg'], 700, 450 );
            if ( $img ) { set_post_thumbnail( $id, $img ); }
            $count++;
        }
        return array( 'success' => true, 'message' => 'Events: ' . $count . ' imported' );
    }
}

/* ============================================================
   STEP 8 — OFFERS
============================================================ */
if ( ! function_exists( 'phoenix_import_offers' ) ) {
    function phoenix_import_offers() {
        $items = array(
            array( 'title' => 'Timezone Fun Package - Bumper Car + Ticket Games + Video Games',         'price' => 'NOW ONLY@599', 'validity' => '30th June 2026', 'type' => 'package', 'color' => '#c0392b', 'bg' => '#1a0505' ),
            array( 'title' => 'Timezone Premium Package - Bowling + VR + Bumper Car + Games',           'price' => 'NOW ONLY@745', 'validity' => '30th June 2026', 'type' => 'package', 'color' => '#1a2a5c', 'bg' => '#050a1a' ),
            array( 'title' => 'Smart Watch Offer - Shop Rs.25000 & Get Assured Smart Watch',            'price' => 'Shop Rs.25,000','validity' => '31st March 2026','type' => 'offer',   'color' => '#C9A84C', 'bg' => '#1a1500' ),
        );
        $count = 0;
        foreach ( $items as $o ) {
            $ex = get_posts( array( 'post_type' => 'offer', 'post_status' => 'any', 'numberposts' => 1, 'title' => $o['title'] ) );
            if ( $ex ) { continue; }
            $id = wp_insert_post( array( 'post_title' => $o['title'], 'post_status' => 'publish', 'post_type' => 'offer', 'post_content' => '' ) );
            if ( is_wp_error( $id ) ) { continue; }
            update_post_meta( $id, '_offer_price',        $o['price'] );
            update_post_meta( $id, '_offer_validity',     $o['validity'] );
            update_post_meta( $id, '_offer_type_select',  $o['type'] );
            $img = phoenix_make_image( $o['title'], $o['color'], $o['bg'], 600, 400 );
            if ( $img ) { set_post_thumbnail( $id, $img ); }
            $count++;
        }
        return array( 'success' => true, 'message' => 'Offers & Packages: ' . $count . ' imported' );
    }
}

/* ============================================================
   STEP 9 — BLOG POSTS
============================================================ */
if ( ! function_exists( 'phoenix_import_posts' ) ) {
    function phoenix_import_posts() {
        $items = array(
            array(
                'title'   => 'Republic Day Celebrations at Phoenix Palassio Lucknow',
                'date'    => '2026-01-23',
                'content' => '<p>Phoenix Palassio, Lucknow celebrated Republic Day with great enthusiasm and patriotic fervor. The mall was decked up in the colors of the tricolor, creating a festive and patriotic atmosphere throughout.</p><p>The celebrations began with a flag hoisting ceremony followed by cultural performances by local artists. Special Republic Day offers were available across all stores, making it a perfect day to shop while celebrating the spirit of India.</p>',
                'color'   => '#c0392b', 'bg' => '#1a0505',
            ),
            array(
                'title'   => 'Athleisure and Sneakers - The New Cool',
                'date'    => '2026-02-07',
                'content' => '<p>Athleisure wear has transcended the gym and is now a mainstream fashion statement. At Phoenix Palassio, Lucknow, you will find the best collection of athleisure wear and sneakers from top brands like Adidas, American Eagle, and more.</p><p>From performance wear to street-style casual, our mall houses all the leading sports and lifestyle brands under one roof.</p>',
                'color'   => '#1a3a5c', 'bg' => '#050a1a',
            ),
            array(
                'title'   => 'Top 10 Restaurants to Visit at Phoenix Palassio',
                'date'    => '2026-02-15',
                'content' => '<p>Phoenix Palassio, Lucknow is a paradise for food lovers. With a wide range of dining options from fine dining to quick service outlets, there is something for everyone.</p><p>Must visit: Ishaara, Punjab Grill, Dobaraa, EIGHT, Jamie\'s Pizzeria, KFC, Pizza Hut, Burger King, Subway, and Cinnabon.</p>',
                'color'   => '#5a2d00', 'bg' => '#1a0a00',
            ),
        );
        $ids   = array();
        $count = 0;
        foreach ( $items as $p ) {
            $ex = get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'numberposts' => 1, 'title' => $p['title'] ) );
            if ( $ex ) { continue; }
            $id = wp_insert_post( array(
                'post_title'   => $p['title'],
                'post_status'  => 'publish',
                'post_type'    => 'post',
                'post_content' => $p['content'],
                'post_date'    => $p['date'] . ' 10:00:00',
            ) );
            if ( is_wp_error( $id ) ) { continue; }
            $img = phoenix_make_image( $p['title'], $p['color'], $p['bg'], 800, 500 );
            if ( $img ) { set_post_thumbnail( $id, $img ); }
            $ids[] = $id;
            $count++;
        }
        update_option( 'phoenix_demo_post_ids', $ids );
        return array( 'success' => true, 'message' => 'Blog Posts: ' . $count . ' imported' );
    }
}

/* ============================================================
   STEP 10 — MENUS
============================================================ */
if ( ! function_exists( 'phoenix_import_menus' ) ) {
    function phoenix_import_menus() {
        $primary_pages = array( 'Brands', 'Dine', 'Entertainment', 'Offers and Packages', 'Events', 'Concierge Services', 'Gift Card' );
        $menu_name     = 'Phoenix Primary Menu';
        $menu_obj      = wp_get_nav_menu_object( $menu_name );
        if ( $menu_obj ) {
            $menu_id = $menu_obj->term_id;
            $existing = wp_get_nav_menu_items( $menu_id );
            if ( $existing ) {
                foreach ( $existing as $mi ) {
                    wp_delete_post( $mi->ID, true );
                }
            }
        } else {
            $menu_id = wp_create_nav_menu( $menu_name );
        }
        $added = 0;
        foreach ( $primary_pages as $pt ) {
            $page = get_page_by_title( $pt );
            if ( ! $page ) { continue; }
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'     => $page->post_title,
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $page->ID,
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ) );
            $added++;
        }
        $locs             = get_theme_mod( 'nav_menu_locations', array() );
        $locs['primary']  = $menu_id;
        $footer_menus = array(
            'who-we-are'   => array( 'About Us', 'Leasing', 'Tourist', 'Company Profile' ),
            'get-involved' => array( 'Contact Us', 'Career', 'Terms & Conditions', 'Privacy Policy', 'Investors' ),
            'latest'       => array( 'News', 'Blogs', 'Events' ),
        );
        foreach ( $footer_menus as $loc => $menu_items ) {
            $mname = ucwords( str_replace( '-', ' ', $loc ) );
            $mobj  = wp_get_nav_menu_object( $mname );
            $mid   = $mobj ? $mobj->term_id : wp_create_nav_menu( $mname );
            foreach ( $menu_items as $item ) {
                wp_update_nav_menu_item( $mid, 0, array( 'menu-item-title' => $item, 'menu-item-type' => 'custom', 'menu-item-url' => '#', 'menu-item-status' => 'publish' ) );
            }
            $locs[ $loc ] = $mid;
        }
        set_theme_mod( 'nav_menu_locations', $locs );
        return array( 'success' => true, 'message' => 'Menus: Primary (' . $added . ' items) + 3 footer menus created' );
    }
}

/* ============================================================
   STEP 11 — FINALIZE
============================================================ */
if ( ! function_exists( 'phoenix_import_finalize' ) ) {
    function phoenix_import_finalize() {
        update_option( 'permalink_structure', '/%postname%/' );
        flush_rewrite_rules( true );
        $name = get_option( 'blogname', '' );
        if ( in_array( $name, array( 'My WordPress Blog', 'My WordPress Website', 'WordPress', '' ) ) ) {
            update_option( 'blogname',        'Phoenix Palassio' );
            update_option( 'blogdescription', 'Lucknow Premier Shopping Destination' );
        }
        update_option( 'phoenix_demo_imported',  current_time( 'mysql' ) );
        update_option( 'phoenix_import_version', '1.0' );
        return array( 'success' => true, 'message' => 'Done! Your site is ready. Visit the homepage now.' );
    }
}

/* ============================================================
   RESET
============================================================ */
if ( ! function_exists( 'phoenix_reset_demo_data' ) ) {
    function phoenix_reset_demo_data() {
        $del = 0;
        $types = array( 'slide', 'brand', 'restaurant', 'entertainment', 'event', 'offer' );
        foreach ( $types as $pt ) {
            $posts = get_posts( array( 'post_type' => $pt, 'posts_per_page' => -1, 'post_status' => 'any' ) );
            foreach ( $posts as $p ) {
                $tid = get_post_thumbnail_id( $p->ID );
                if ( $tid ) { wp_delete_attachment( $tid, true ); }
                wp_delete_post( $p->ID, true );
                $del++;
            }
        }
        foreach ( get_option( 'phoenix_demo_post_ids', array() ) as $pid ) {
            $tid = get_post_thumbnail_id( $pid );
            if ( $tid ) { wp_delete_attachment( $tid, true ); }
            wp_delete_post( $pid, true );
        }
        delete_option( 'phoenix_demo_imported' );
        delete_option( 'phoenix_demo_post_ids' );
        return array( 'success' => true, 'message' => 'Deleted ' . $del . ' items. Ready for fresh import.' );
    }
}

/* ============================================================
   WIZARD PAGE HTML
============================================================ */
if ( ! function_exists( 'phoenix_setup_wizard_page' ) ) {
    function phoenix_setup_wizard_page() {
        $imported  = get_option( 'phoenix_demo_imported' );
        $nonce     = wp_create_nonce( 'phoenix_import_nonce' );
        $site_url  = home_url( '/' );
        $ajax_url  = admin_url( 'admin-ajax.php' );
        $steps_def = array(
            array( 'id' => 'customizer',    'icon' => '⚙️',  'label' => 'Mall Settings',      'desc' => 'Timings, phone, address, social links' ),
            array( 'id' => 'pages',         'icon' => '📄',  'label' => 'Pages (9)',           'desc' => 'All pages with correct templates'       ),
            array( 'id' => 'slides',        'icon' => '🖼️',  'label' => 'Hero Slides (3)',     'desc' => 'Homepage hero banners with images'      ),
            array( 'id' => 'brands',        'icon' => '🛍️',  'label' => 'Brands (25)',         'desc' => 'Fashion, sports, accessories brands'    ),
            array( 'id' => 'restaurants',   'icon' => '🍽️',  'label' => 'Restaurants (12)',    'desc' => 'Fine dining to food courts'             ),
            array( 'id' => 'entertainment', 'icon' => '🎮',  'label' => 'Entertainment (3)',   'desc' => 'Timezone, House of Fear, 9D VR'         ),
            array( 'id' => 'events',        'icon' => '🎪',  'label' => 'Events (4)',           'desc' => 'Upcoming mall events'                   ),
            array( 'id' => 'offers',        'icon' => '🏷️',  'label' => 'Offers & Packages',  'desc' => 'Mall packages + current offers'         ),
            array( 'id' => 'posts',         'icon' => '📝',  'label' => 'Blog Posts (3)',       'desc' => 'Featured articles and news'             ),
            array( 'id' => 'menus',         'icon' => '🧭',  'label' => 'Navigation Menus',    'desc' => 'Primary + 3 footer menu columns'        ),
            array( 'id' => 'finalize',      'icon' => '🚀',  'label' => 'Finalize',             'desc' => 'Set permalinks and mark complete'       ),
        );
        $steps_json = json_encode( array_column( $steps_def, 'id' ) );
        ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#f0f0f1;padding:20px}
#ppwrap{max-width:900px;margin:0 auto}
.pp-head{background:linear-gradient(135deg,#0a0a0a 0%,#1a1a2e 60%,#0a0a0a 100%);border-radius:14px;padding:44px 40px;text-align:center;margin-bottom:24px}
.pp-name{font-size:2.8rem;font-weight:900;color:#fff;letter-spacing:6px;display:block}
.pp-sub{font-size:.65rem;letter-spacing:8px;color:#C9A84C;font-weight:600;margin-bottom:8px;display:block}
.pp-desc{color:rgba(255,255,255,.7);font-size:.95rem;margin-top:12px}
.pp-desc strong{color:#C9A84C}
.card{background:#fff;border-radius:10px;padding:22px 26px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,.06)}
.card h3{font-size:1rem;color:#333;margin-bottom:14px}
.prog-wrap{background:#eee;border-radius:50px;height:14px;overflow:hidden;margin-bottom:8px}
.prog-bar{background:linear-gradient(90deg,#C9A84C,#E8C96A);height:100%;border-radius:50px;width:0%;transition:width .4s ease}
.prog-txt{font-size:.8rem;color:#888}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px}
.step{background:#fff;border:2px solid #eee;border-radius:10px;padding:16px 18px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 4px rgba(0,0,0,.04)}
.step.active{border-color:#C9A84C;background:#fffdf5}
.step.done{border-color:#27ae60;background:#f0fbf4}
.step.error{border-color:#e74c3c;background:#fff5f5}
.step-ico{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;background:#f5f5f5}
.step-info h4{font-size:.88rem;font-weight:700;color:#333;margin-bottom:3px}
.step-info .desc{font-size:.76rem;color:#999}
.step-info .res{font-size:.76rem;font-weight:600;color:#27ae60;display:none}
.step.error .res{color:#e74c3c}
.actions{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:20px}
.btn-go{display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#C9A84C,#9a7828);color:#fff;padding:14px 34px;border-radius:8px;font-size:1rem;font-weight:700;cursor:pointer;border:none;box-shadow:0 4px 14px rgba(201,168,76,.4)}
.btn-go:disabled{opacity:.6;cursor:not-allowed}
.btn-sec{display:inline-flex;align-items:center;gap:8px;background:#fff;color:#666;padding:12px 22px;border-radius:8px;font-size:.88rem;font-weight:600;cursor:pointer;border:2px solid #ddd}
.success-box{background:linear-gradient(135deg,#0a2e1a,#0d3b22);border-radius:10px;padding:30px;color:#fff;text-align:center;margin-bottom:20px;display:none}
.success-box h2{font-size:1.8rem;color:#4ade80;margin-bottom:10px}
.success-box p{color:rgba(255,255,255,.8);margin-bottom:20px}
.success-links{display:flex;justify-content:center;gap:12px;flex-wrap:wrap}
.success-links a{background:#C9A84C;color:#fff;padding:11px 22px;border-radius:6px;text-decoration:none;font-weight:700;font-size:.88rem}
.success-links a.sec{background:rgba(255,255,255,.15)}
.log{background:#0d0d0d;border-radius:8px;padding:16px;font-family:monospace;font-size:.78rem;color:#bbb;max-height:180px;overflow-y:auto;display:none;margin-bottom:20px}
.log-ln{padding:2px 0}
.log-ln.ok{color:#4ade80}.log-ln.er{color:#f87171}.log-ln.in{color:#C9A84C}
.spin{display:inline-block;width:16px;height:16px;border:3px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:sp .75s linear infinite;vertical-align:middle}
@keyframes sp{to{transform:rotate(360deg)}}
.already{background:#fffdf0;border:2px solid #C9A84C;border-radius:10px;padding:18px 22px;margin-bottom:20px;display:flex;align-items:center;gap:15px}
.info-box{background:#f4f8ff;border:1px solid #dce8ff;border-radius:8px;padding:18px 22px;margin-bottom:20px}
.info-box h4{color:#1a3a6c;font-size:.92rem;margin-bottom:10px}
.info-box ul{padding-left:18px}.info-box ul li{font-size:.82rem;color:#555;margin-bottom:4px}
@media(max-width:600px){.grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<div id="ppwrap">

    <div class="pp-head">
        <span class="pp-sub">— PHOENIX —</span>
        <span class="pp-name">PALASSIO</span>
        <p class="pp-desc">One-Click Demo Setup &mdash; Import <strong>all pages, brands, restaurants, events &amp; more</strong> instantly.</p>
    </div>

    <?php if ( $imported ) : ?>
    <div class="already">
        <span style="font-size:2rem">✅</span>
        <div>
            <strong>Demo imported on <?php echo esc_html( $imported ); ?></strong>
            <p style="color:#888;font-size:.83rem;margin-top:4px">Re-run to refresh content, or reset and start fresh.</p>
        </div>
        <a href="<?php echo esc_url( $site_url ); ?>" target="_blank" style="margin-left:auto;background:#C9A84C;color:#fff;padding:10px 20px;border-radius:6px;text-decoration:none;font-weight:700;font-size:.85rem">View Site</a>
    </div>
    <?php endif; ?>

    <div class="info-box">
        <h4>What will be imported:</h4>
        <ul>
            <li><strong>9 Pages</strong> — Home, Brands, Dine, Entertainment, Fun &amp; Games, Offers, Events, Concierge, Gift Card</li>
            <li><strong>25 Brands</strong> — Lifestyle, Forever 21, Adidas, Allen Solly, Armani Exchange, ALDO &amp; more with images</li>
            <li><strong>12 Restaurants</strong> — Ishaara, Punjab Grill, KFC, Pizza Hut, Burger King, Subway &amp; more</li>
            <li><strong>3 Entertainment</strong> — Timezone, House of Fear, 9D Virtual Reality</li>
            <li><strong>4 Events</strong> — Table Tennis, Republic Day, Food Festival, Fashion Showcase</li>
            <li><strong>3 Offers &amp; Packages</strong> — Timezone packages + Smart Watch offer</li>
            <li><strong>3 Blog Posts</strong> — Republic Day, Athleisure, Top 10 Restaurants</li>
            <li><strong>Menus</strong> — Primary nav + 3 footer menu columns</li>
            <li><strong>Mall Settings</strong> — Timings, phone, address, social links</li>
        </ul>
    </div>

    <div class="card">
        <h3>Import Progress</h3>
        <div class="prog-wrap"><div class="prog-bar" id="ppbar"></div></div>
        <p class="prog-txt" id="pptxt">Ready to import. Click "Start Full Import" to begin.</p>
    </div>

    <div class="grid" id="ppgrid">
        <?php foreach ( $steps_def as $s ) : ?>
        <div class="step" id="st-<?php echo esc_attr( $s['id'] ); ?>">
            <div class="step-ico"><?php echo $s['icon']; ?></div>
            <div class="step-info">
                <h4><?php echo esc_html( $s['label'] ); ?></h4>
                <p class="desc"><?php echo esc_html( $s['desc'] ); ?></p>
                <p class="res"></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <button id="pp-go" class="btn-go">🚀 <span id="pp-go-txt">Start Full Import</span></button>
        <?php if ( $imported ) : ?>
        <button id="pp-reset" class="btn-sec" style="border-color:#e74c3c;color:#e74c3c;">🗑️ Reset Demo Data</button>
        <?php endif; ?>
        <button id="pp-log-btn" class="btn-sec" style="margin-left:auto">📋 Show Log</button>
    </div>

    <div class="log" id="pplog"></div>

    <div class="success-box" id="pp-success">
        <h2>🎉 Your Site is Ready!</h2>
        <p>All demo content imported. Phoenix Palassio is now live!</p>
        <div class="success-links">
            <a href="<?php echo esc_url( $site_url ); ?>" target="_blank">View Site</a>
            <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank" class="sec">Customize</a>
            <a href="<?php echo esc_url( admin_url( 'upload.php' ) ); ?>" target="_blank" class="sec">Media Library</a>
            <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=brand' ) ); ?>" class="sec">Manage Brands</a>
        </div>
    </div>

</div>

<script>
(function(){
    var steps   = <?php echo $steps_json; ?>;
    var nonce   = '<?php echo esc_js( $nonce ); ?>';
    var ajaxUrl = '<?php echo esc_js( $ajax_url ); ?>';
    var cur = 0, running = false;

    function log(m, t) {
        var d = document.getElementById('pplog');
        d.innerHTML += '<div class="log-ln ' + (t || 'in') + '">[' + new Date().toLocaleTimeString() + '] ' + m + '</div>';
        d.scrollTop = d.scrollHeight;
    }

    function prog(n) {
        var p = Math.round(n / steps.length * 100);
        document.getElementById('ppbar').style.width = p + '%';
        document.getElementById('pptxt').textContent = p + '% - Step ' + n + ' of ' + steps.length;
    }

    function setState(id, st, msg) {
        var el = document.getElementById('st-' + id);
        if (!el) return;
        el.className = 'step ' + st;
        var r = el.querySelector('.res');
        var d = el.querySelector('.desc');
        if (msg) {
            r.textContent = msg;
            r.style.display = 'block';
            if (d) d.style.display = 'none';
        }
    }

    function runStep() {
        if (cur >= steps.length) {
            running = false;
            document.getElementById('pp-go').disabled = false;
            document.getElementById('pp-go-txt').textContent = 'Import Complete!';
            document.getElementById('pp-success').style.display = 'block';
            prog(steps.length);
            log('All done! Your site is ready.', 'ok');
            return;
        }
        var step = steps[cur];
        setState(step, 'active');
        document.getElementById('pptxt').textContent = 'Running: ' + step + '...';
        log('Starting: ' + step, 'in');

        var fd = new FormData();
        fd.append('action', 'phoenix_import_step');
        fd.append('nonce',  nonce);
        fd.append('step',   step);

        fetch(ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(function(r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.text();
        })
        .then(function(raw) {
            var js = raw.indexOf('{');
            var je = raw.lastIndexOf('}');
            if (js === -1 || je === -1) throw new Error('Bad response: ' + raw.substring(0, 100));
            var data = JSON.parse(raw.substring(js, je + 1));
            if (data && data.success !== false) {
                setState(step, 'done', data.message || 'Done');
                log(data.message || 'Done', 'ok');
            } else {
                var e = (data && data.message) ? data.message : 'Unknown error';
                setState(step, 'error', 'Error: ' + e);
                log('Error: ' + e, 'er');
            }
            cur++;
            prog(cur);
            setTimeout(runStep, 400);
        })
        .catch(function(err) {
            setState(step, 'error', 'Error: ' + err.message);
            log('Error on ' + step + ': ' + err.message, 'er');
            cur++;
            prog(cur);
            setTimeout(runStep, 500);
        });
    }

    document.getElementById('pp-go').addEventListener('click', function() {
        if (running) return;
        running = true;
        cur = 0;
        this.disabled = true;
        document.getElementById('pp-go-txt').innerHTML = '<span class="spin"></span> Importing...';
        document.getElementById('pp-success').style.display = 'none';
        document.getElementById('ppbar').style.width = '0%';
        document.getElementById('pptxt').textContent = 'Starting...';
        document.getElementById('pplog').innerHTML = '';
        var allSteps = document.querySelectorAll('.step');
        for (var i = 0; i < allSteps.length; i++) {
            allSteps[i].className = 'step';
            var r = allSteps[i].querySelector('.res');
            var d = allSteps[i].querySelector('.desc');
            if (r) { r.textContent = ''; r.style.display = 'none'; }
            if (d) d.style.display = 'block';
        }
        log('Starting Phoenix Palassio demo import...', 'in');
        runStep();
    });

    document.getElementById('pp-log-btn').addEventListener('click', function() {
        var l = document.getElementById('pplog');
        l.style.display = (l.style.display === 'block') ? 'none' : 'block';
        this.textContent = (l.style.display === 'block') ? 'Hide Log' : 'Show Log';
    });

    <?php if ( $imported ) : ?>
    document.getElementById('pp-reset').addEventListener('click', function() {
        if (!confirm('Delete all imported demo content?')) return;
        var btn = this;
        btn.disabled = true;
        btn.textContent = 'Resetting...';
        var fd = new FormData();
        fd.append('action', 'phoenix_reset_demo');
        fd.append('nonce',  nonce);
        fetch(ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            alert(d.success ? ('Done: ' + d.data.message) : 'Reset failed');
            location.reload();
        })
        .catch(function() {
            alert('Network error during reset');
            btn.disabled = false;
            btn.textContent = 'Reset Demo Data';
        });
    });
    <?php endif; ?>
})();
</script>
</body>
</html>
        <?php
    }
}
