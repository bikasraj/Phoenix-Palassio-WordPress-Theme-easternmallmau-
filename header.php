<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-left">
            <div class="mall-timings">
                <i class="fa-solid fa-clock"></i>
                <span><?php esc_html_e( 'MALL TIMINGS', 'phoenix-palassio' ); ?></span>
                <?php echo esc_html( phoenix_get_option( 'mall_timings', 'Every day • 11:00AM – 10:00PM' ) ); ?>
            </div>
            <div class="top-bar-social">
                <?php if ( phoenix_get_option('facebook_url') ) : ?>
                    <a href="<?php echo esc_url( phoenix_get_option('facebook_url') ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                <?php if ( phoenix_get_option('twitter_url') ) : ?>
                    <a href="<?php echo esc_url( phoenix_get_option('twitter_url') ); ?>" target="_blank" rel="noopener" aria-label="Twitter/X"><i class="fab fa-x-twitter"></i></a>
                <?php endif; ?>
                <?php if ( phoenix_get_option('youtube_url') ) : ?>
                    <a href="<?php echo esc_url( phoenix_get_option('youtube_url') ); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <?php endif; ?>
                <?php if ( phoenix_get_option('instagram_url') ) : ?>
                    <a href="<?php echo esc_url( phoenix_get_option('instagram_url') ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <div class="top-bar-right">
            <a href="tel:<?php echo esc_attr( phoenix_get_option( 'mall_phone', '05226667700' ) ); ?>">
                <i class="fa-solid fa-phone"></i>
                <?php echo esc_html( phoenix_get_option( 'mall_phone', '05226667700' ) ); ?>
            </a>
            <a href="#getting-here">
                <i class="fa-solid fa-location-dot"></i>
                <?php esc_html_e( 'GETTING HERE', 'phoenix-palassio' ); ?>
            </a>
            <a href="#mall-map">
                <i class="fa-regular fa-map"></i>
                <?php esc_html_e( 'MALL MAP', 'phoenix-palassio' ); ?>
            </a>
            <div class="top-bar-actions">
                <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="btn-signin">
                    <?php esc_html_e( 'SIGN IN / REGISTER', 'phoenix-palassio' ); ?>
                </a>
                <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <?php esc_html_e( 'CART', 'phoenix-palassio' ); ?>
                    </a>
                <?php else : ?>
                    <a href="#" class="cart-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <?php esc_html_e( 'CART', 'phoenix-palassio' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- MAIN HEADER -->
<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <div class="site-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php if ( has_custom_logo() ) :
                        the_custom_logo();
                    else :
                        $logo_path_png = PHOENIX_PALASSIO_DIR . '/images/logo.png';
                        $logo_path_svg = PHOENIX_PALASSIO_DIR . '/images/logo.svg';
                        if ( file_exists( $logo_path_png ) ) : ?>
                            <img src="<?php echo esc_url( PHOENIX_PALASSIO_URI . '/images/logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" style="height:55px;width:auto;">
                        <?php elseif ( file_exists( $logo_path_svg ) ) : ?>
                            <img src="<?php echo esc_url( PHOENIX_PALASSIO_URI . '/images/logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" style="height:55px;width:auto;">
                        <?php else : ?>
                            <div style="display:flex;flex-direction:column;align-items:flex-start;line-height:1.2;">
                                <span style="font-size:0.58rem;letter-spacing:4px;color:var(--gold);font-weight:700;font-family:var(--font-body);">— PHOENIX —</span>
                                <span style="font-size:1.4rem;font-weight:800;color:var(--black);letter-spacing:3px;font-family:var(--font-heading);">PALASSIO</span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
                <div class="location-selector">
                    <span style="font-size:0.6rem;letter-spacing:1px;color:var(--gray);display:block;margin-bottom:1px;"><?php esc_html_e( 'LOCATION', 'phoenix-palassio' ); ?></span>
                    <strong><?php echo esc_html( phoenix_get_option( 'mall_location', 'Lucknow, Phoenix Palassio' ) ); ?></strong>
                    <i class="fa-solid fa-chevron-down" style="font-size:0.65rem;"></i>
                </div>
            </div>

            <!-- Primary Navigation -->
            <nav class="main-nav" id="main-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'phoenix-palassio' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => '',
                    'container'      => false,
                    'fallback_cb'    => 'phoenix_default_nav',
                ) );
                ?>
            </nav>

            <!-- Search + Mobile Toggle -->
            <div class="header-actions" style="display:flex;align-items:center;gap:10px;">
                <button class="header-search" aria-label="Search" id="search-toggle">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Toggle Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </div>
    </div>
</header>

<!-- MOBILE NAV -->
<div class="mobile-nav" id="mobile-nav">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close Menu">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <?php
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'menu_class'     => '',
        'container'      => false,
        'fallback_cb'    => 'phoenix_default_nav',
    ) );
    ?>
</div>

<!-- SEARCH OVERLAY -->
<div class="search-overlay" id="search-overlay">
    <div class="search-overlay-inner">
        <button class="search-close" id="search-close" aria-label="Close Search">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <?php get_search_form(); ?>
    </div>
</div>

<?php
if ( ! function_exists( 'phoenix_default_nav' ) ) {
    function phoenix_default_nav() {
        $pages = array(
            'brands'              => 'BRANDS',
            'dine'                => 'DINE',
            'entertainment'       => 'ENTERTAINMENT',
            'offers-and-packages' => 'OFFERS &amp; PACKAGES',
            'events'              => 'EVENTS',
            'concierge-services'  => 'CONCIERGE SERVICES',
            'gift-card'           => 'GIFT CARD',
        );
        echo '<ul>';
        foreach ( $pages as $slug => $label ) {
            $current = ( is_page( $slug ) || is_post_type_archive( $slug ) ) ? ' class="current-menu-item"' : '';
            printf(
                '<li%s><a href="%s">%s</a></li>',
                $current,
                esc_url( home_url( '/' . $slug . '/' ) ),
                $label
            );
        }
        echo '</ul>';
    }
}
?>
